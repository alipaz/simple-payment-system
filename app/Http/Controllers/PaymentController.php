<?php

namespace App\Http\Controllers;

use App\DataTransferObject\CallBackRequestDto;
use App\DataTransferObject\CheckoutRequestDto;
use App\Http\Requests\Payment\CheckoutPayRequest;
use App\Http\Requests\Payment\PaymentCallBackRequest;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class PaymentController extends Controller
{

    public function __construct(
        protected PaymentService $paymentService
    )
    {
    }


    /**
     * @param CheckoutPayRequest $checkoutPayRequest
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pay(CheckoutPayRequest $checkoutPayRequest, Order $order)
    {
       return $this->paymentService->prepareCreatePaymentRequest(
            CheckoutRequestDto::fromCheckoutPaymentRequest($checkoutPayRequest, $order)
        );
    }


    /**
     * @param PaymentCallBackRequest $paymentCallBackRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callBack(PaymentCallBackRequest $paymentCallBackRequest): RedirectResponse
    {
        $result = $this->paymentService->backFromPaymentGateWay(
            CallBackRequestDto::fromPaymentCallBackRequest($paymentCallBackRequest)
        );

        if ($result === Payment::class) {
            return redirect()->route('payment.success', ['payment' => $result]);
        } else {
            return redirect()->route('payment.failed', ['errorMessage' => $result]);
        }
    }


    /**
     * @param Payment $payment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showPaymentSuccessResult(Payment $payment)
    {
        return view('payment.success', compact('payment'));
    }



    public function showPaymentFailedResult($errorMessage = null)
    {
        return view('payment.failed', ['errorMessage' => $errorMessage]);
    }

}
