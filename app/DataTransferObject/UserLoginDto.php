<?php
namespace App\DataTransferObject;

use App\Http\Requests\User\StoreUserValidation;
use App\Http\Requests\User\UserLoginRequest;
use App\Models\User;

class UserLoginDto
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    )
    {
    }


    /**
     * @param UserLoginRequest $userValidation
     * @return UserLoginDto
     */
    public static function fromUserLoginRequest(UserLoginRequest $userValidation): UserLoginDto
    {
        return new self(
            email: $userValidation->validated(User::COLUMN_EMAIL),
            password: $userValidation->validated(User::COLUMN_PASSWORD),
        );
    }
}
