<?php

namespace App\Http\Requests\Payment;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutPayRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            User::COLUMN_CARD_NUMBER => [
                'required',
                'string',
                'size:16',
            ],
        ];
    }
}
