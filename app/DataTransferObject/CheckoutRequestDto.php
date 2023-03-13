<?php

namespace App\DataTransferObject;

use App\Http\Requests\Payment\CheckoutPayRequest;
use App\Models\Order;
use App\Models\User;

class CheckoutRequestDto
{
    public function __construct(
        public string $cardNumber,
        public object $order,
    )
    {
    }

    public static function fromCheckoutPaymentRequest(CheckoutPayRequest $checkoutPayRequest, Order $order): CheckoutRequestDto
    {
        return new self(
            cardNumber: $checkoutPayRequest->validated(User::COLUMN_CARD_NUMBER),
            order: $order,
        );
    }
}
