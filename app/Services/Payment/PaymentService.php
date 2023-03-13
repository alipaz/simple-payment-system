<?php

namespace App\Services\Payment;

use App\Exceptions\PaymentError;
use App\Exceptions\PaymentErrorException;
use App\Models\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;

class PaymentService
{
    const CALL_BACK_URL                = 'http://localhost:8084/payment/call-back';
    const CALL_BACK_METHOD_GET         = 1;
    const CALL_BACK_STATUS_SUCCESS     = 1;
    const CONTENT_TYPE                 = 'application/json';

    /**
     * @var Client
     */
    private Client $httpClient;

    /**
     * @var Payment
     */
    private Payment $paymentModel;

    /**
     * @param Client $httpClient
     * @param Payment $paymentModel
     */
    public function __construct(Client $httpClient, Payment $paymentModel)
    {
        $this->httpClient   = $httpClient;
        $this->paymentModel = $paymentModel;
    }


    /**
     * @param $order
     * @return RedirectResponse|void
     * @throws GuzzleException
     */
    public function prepareCreatePaymentRequest($order)
    {
        $headers = $this->prepareRequestHeader();

        $body = $this->prepareBodyForCreatePaymentRequest($order);

        return $this->sendCreateRequestToPaymentGateway($headers, $body);
    }


    /**
     * @param array $headers
     * @param array $body
     * @return string|void
     * @throws GuzzleException
     */
    public function sendCreateRequestToPaymentGateway(array $headers, array $body)
    {
        try {
            $request = new Request('POST', 'https://core.paystar.ir/api/pardakht/create', $headers, json_encode($body));

            $response = $this->httpClient->sendAsync($request)->wait();

            $responseBody = json_decode($response->getBody(), true);

            $this->createNewPaymentForOrder($responseBody['data']);

            $this->paymentCallBack($responseBody['data']['token']);
        } catch (\Exception $e) {
            throw new PaymentErrorException($e->getMessage());
        }
    }

    /**
     * @return string[]
     */
    public function prepareRequestHeader(): array
    {
        return [
            'Authorization' => env('PAYSTAR_AUTH_TOKEN'),
            'Content-Type' => self::CONTENT_TYPE
        ];
    }

    /**
     * @param $order
     * @return array
     */
    public function prepareBodyForCreatePaymentRequest($order): array
    {
        //TODO FIX
        $amount  = $order->order->total_cost;
        $orderId = $order->order->id;

        return [
            'amount'          => $amount,
            'order_id'        => $orderId,
            'callback'        => self::CALL_BACK_URL,
            'sign'            => $this->generatePaymentSignOnCreateRequest($amount, $orderId),
            'callback_method' => self::CALL_BACK_METHOD_GET
        ];
    }

    /**
     * @param string $amount
     * @param int $orderId
     * @return string
     */
    public function generatePaymentSignOnCreateRequest(string $amount, int $orderId): string
    {
        $data = "$amount#$orderId#" . self::CALL_BACK_URL;

        return $this->generateSign($data, env('PAYSTAR_SECRET_KEY'));
    }

    /**
     * @param string $amount
     * @param string $referenceNumber
     * @param int $cardNumber
     * @param string $trackingCode
     * @return string
     */
    public function generatePaymentSignOnVerifyPayment($amount, $referenceNumber, $cardNumber, $trackingCode): string
    {
        $data = "$amount#$referenceNumber#$cardNumber#$trackingCode";

        return $this->generateSign($data, env('PAYSTAR_SECRET_KEY'));
    }

    /**
     * @param string $data
     * @param $secretKey
     * @param string $algorithm
     * @return false|string
     */
    public function generateSign($data, $secretKey, $algorithm = 'sha512'): string|false
    {
        return hash_hmac($algorithm, $data, $secretKey);
    }


    /**
     * @param $responseData
     * @return mixed
     */
    public function createNewPaymentForOrder($responseData): mixed
    {
        return $this->paymentModel->storeNewPayment($responseData);
    }


    /**
     * @param string $token
     * @return string|void
     * @throws GuzzleException
     */
    public function paymentCallBack(string $token)
    {
        $response = $this->httpClient->request('POST', 'https://core.paystar.ir/api/pardakht/payment', [
            'form_params' => [
                'token' => $token,
            ],
        ]);

        echo $response->getBody();
    }


    /**
     * @param object $callBackData
     * @return mixed|void
     */
    public function backFromPaymentGateWay(object $callBackData)
    {
        if (!$this->isCallBackDataValid($callBackData)) {
            return $callBackData->message;
        }

        $payment = $this->paymentModel->getPaymentByReferenceNumber($callBackData->ref_num);

        if (!$this->isCardNumberCompatibleWithPayment($callBackData->card_number, $payment)) {
            return 'Card number is not compatible with payment.';
        }

        $updatedPayment = $this->paymentModel->updatePaymentWhenSuccess($payment, $callBackData);

        $this->verifyPayment($updatedPayment);

        $this->paymentModel->updatePaymentStatusWhenPaymentVerified($updatedPayment);

        return $updatedPayment;
    }

    /**
     * @param object $callBackData
     * @return bool
     */
    private function isCallBackDataValid(object $callBackData): bool
    {
        return $callBackData->status === self::CALL_BACK_STATUS_SUCCESS;
    }

    /**
     * @param string $cardNumber
     * @param Payment $payment
     * @return bool
     */
    private function isCardNumberCompatibleWithPayment(string $cardNumber, Payment $payment): bool
    {
        $userCardNumber = $this->paymentModel->getUserCardNumberWithReferenceNumber($payment->reference_number);

        return $this->checkIsCardNumberCompatibleWithPayment($cardNumber, $userCardNumber);
    }



    public function verifyPayment($paymentData)
    {
        $headers = $this->prepareRequestHeader();
        $body = $this->prepareBodyOnPaymentVerifyRequest
        (
            $paymentData->amount,
            $paymentData->reference_number,
            $paymentData->card_number,
            $paymentData->tracking_code
        );

       return $this->sendVerifyPaymentRequest($headers, $body);
    }


    /**
     * @param $headers
     * @param $body
     * @return RedirectResponse|mixed
     */
    public function sendVerifyPaymentRequest($headers, $body)
    {
        try {
            $request = new Request('POST', 'https://core.paystar.ir/api/pardakht/verify', $headers, json_encode($body));

            return $this->httpClient->sendAsync($request)->wait();

        }catch (\Exception $e) {
            throw new PaymentErrorException($e->getMessage());
        }
    }

    /**
     * @param string $referenceNumber
     * @param int $amount
     * @param int $cardNumber
     * @param string $trackingCode
     * @return array
     */
    public function prepareBodyOnPaymentVerifyRequest($amount, $referenceNumber, $cardNumber, $trackingCode): array
    {
       return [
            'ref_num'         => $referenceNumber,
            'sign'            => $this->generatePaymentSignOnVerifyPayment
             (
               $amount,
               $referenceNumber,
               $cardNumber,
               $trackingCode
             ),
            'amount'          => $amount,
        ];
    }


    /**
     * @param string $paymentCardNumber
     * @param string $userCardNumber
     * @return bool
     */
    public function checkIsCardNumberCompatibleWithPayment(string $paymentCardNumber, string $userCardNumber): bool
    {
        $formattedCardNumber = substr_replace($userCardNumber, str_repeat('*', 6), 6, 6);

        if ($formattedCardNumber !== $paymentCardNumber) {
            return false;
        }

        return true;
    }



}
