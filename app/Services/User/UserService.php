<?php

namespace App\Services\User;

use App\DataTransferObject\UsersDto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @param UsersDto $usersDto
     * @return mixed
     */
    public function registerNewUser(UsersDto $usersDto)
    {
        return DB::transaction(function () use ($usersDto) {
            User::create([
                User::COLUMN_FIRST_NAME => $usersDto->firstName,
                User::COLUMN_LAST_NAME  => $usersDto->lastName,
                User::COLUMN_EMAIL      => $usersDto->email,
                User::COLUMN_PASSWORD   => $usersDto->password
            ]);
        });
    }
}
