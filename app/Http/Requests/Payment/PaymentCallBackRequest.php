<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentCallBackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required',
            'ref_num' => 'required|string',
            'order_id' => 'required|integer',
            'tracking_code' => 'string',
            'card_number' => 'string',
            'transaction_id' => 'required|string',
        ];
    }
}
