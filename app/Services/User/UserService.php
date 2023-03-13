<?php

namespace App\Services\User;

use App\DataTransferObject\UsersDto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserService
{


    /**
     * @param UsersDto $usersDto
     * @return mixed
     */
    public function registerNewUser(UsersDto $usersDto): mixed
    {
        return DB::transaction(function () use ($usersDto) {
            $user = User::create([
                User::COLUMN_FIRST_NAME => $usersDto->firstName,
                User::COLUMN_LAST_NAME  => $usersDto->lastName,
                User::COLUMN_EMAIL      => $usersDto->email,
                User::COLUMN_PASSWORD   => bcrypt($usersDto->password)
            ]);

            return $user;
        });
    }


    public function login(array $data)
    {
        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        $remember = isset($data['remember']) && $data['remember'] === 'on';

        return Auth::attempt($credentials, $remember);
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
