<?php

namespace App\Http\Controllers\User;

use App\DataTransferObject\UserLoginDto;
use App\DataTransferObject\UsersDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserValidation;
use App\Http\Requests\User\UserLoginRequest;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
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
     * @return mixed
     */
    public function store(StoreUserValidation $userValidationRequest)
    {
        $user =   $this->userService->registerNewUser(
            UsersDto::fromUserStoreRequest($userValidationRequest)
        );

        Auth::login($user);

        return redirect()->route('checkout.show', ['order' => 1]);
    }

    public function login(UserLoginRequest $loginRequest)
    {
        $success = $this->userService->login(
            UserLoginDto::fromUserLoginRequest($loginRequest)
        );

        if ($success) {
            return redirect()->route('checkout.show', ['order' => 1]);
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.create');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('user.create');
    }

}
