<?php

namespace App\Http\Controllers\User;

use App\DataTransferObject\UsersDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserValidation;
use App\Services\User\UserService;
use Illuminate\View\View;

class UserController extends Controller
{


    public function __construct(
        protected UserService $userService,
    )
    {
    }

    /**
     * @param StoreUserValidation $userValidationRequest
     * @return void
     */
    public function store(StoreUserValidation $userValidationRequest)
    {
      return $this->userService->registerNewUser(
            UsersDto::fromUserRequest($userValidationRequest)
        );

    }

}
