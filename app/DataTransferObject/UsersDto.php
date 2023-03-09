<?php

namespace App\DataTransferObject;

use App\Http\Requests\User\StoreUserValidation;
use App\Models\User;

class UsersDto
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
    )
    {
    }

    /**
     * @param StoreUserValidation $userValidation
     * @return UsersDto
     */
    public static function fromUserStoreRequest(StoreUserValidation $userValidation): UsersDto
    {
            return  new self(
            firstName:   $userValidation->validated(User::COLUMN_FIRST_NAME),
            lastName:    $userValidation->validated(User::COLUMN_LAST_NAME),
            email:       $userValidation->validated(User::COLUMN_EMAIL),
            password:    $userValidation->validated(User::COLUMN_PASSWORD),
        );
    }
}
