<?php

namespace App\DataTransferObject;

use App\Http\Requests\Payment\PaymentCallBackRequest;


class CallBackRequestDto
{

    /**
     * @param int $status
     * @param string $ref_num
     * @param int $order_id
     * @param string $tracking_code
     * @param string $transaction_id
     * @param string $card_number
     */
    public function __construct(
        public int    $status,
        public string $ref_num,
        public int    $order_id,
        public string $tracking_code,
        public string $transaction_id,
        public string $card_number,
    )
    {
    }


    /**
     * @param PaymentCallBackRequest $paymentCallBackRequest
     * @return CallBackRequestDto
     */
    public static function fromPaymentCallBackRequest(PaymentCallBackRequest $paymentCallBackRequest): CallBackRequestDto
    {
        return new self(
            status: $paymentCallBackRequest->validated('status'),
            ref_num: $paymentCallBackRequest->validated('ref_num'),
            order_id: $paymentCallBackRequest->validated('order_id'),
            tracking_code: $paymentCallBackRequest->validated('tracking_code'),
            transaction_id: $paymentCallBackRequest->validated('transaction_id'),
            card_number: $paymentCallBackRequest->validated('card_number'),
        );
    }
}
