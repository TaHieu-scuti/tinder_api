<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function makeRules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|string',
            'password' => 'required|string',
            'c_password' => 'required|same:password'
        ];
    }
}
