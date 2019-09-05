<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends ApiController
{
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function userLogin(UserLoginRequest $request) {
        $validator = $request->validate($request->all());
        if ($validator->hasError()) {
            return $this->errorResponse($validator->getErrors(), 422);
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['accessToken'] = $user->createToken('tinder')->accessToken;
            return $this->successResponse(['success' => $success], 200);
        }

        return $this->errorResponse(['message' => 'Unauthorised'], 401);
    }

    public function userRegister(UserRegisterRequest $request)
    {
        $input = $request->all();
        $validator = $request->validate($input);

        if ($validator->hasError()) {
            return $this->errorResponse($validator->getErrors(), 422);
        }

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['accessToken'] = $user->createToken('tinder')->accessToken;
        $success['name'] = $user->name;
        return $this->successResponse(['success' => $success], 200);
    }

    public function getMe(Request $request)
    {
        return $this->successResponse(['users' => $request->user()]);
    }
}
