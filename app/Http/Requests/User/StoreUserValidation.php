<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserValidation extends FormRequest
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
            User::COLUMN_FIRST_NAME => 'required|max:100',
            User::COLUMN_LAST_NAME => 'required|max:100',
            User::COLUMN_EMAIL => ['required', 'email', 'max:100', Rule::unique('users')],
            User::COLUMN_PASSWORD => 'required|min:8|max:255|confirmed',
//            User::COLUMN_CARD_NUMBER => 'nullable|unique:users|max:16',
        ];
    }

}
