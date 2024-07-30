<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name' => 'required|string',
      'email' => 'required|email|unique:users',
      'country' => 'required|string|size:2',
      'user_type' => 'required|string|in:consumer,business,collector',
      'password' => 'required|string|confirmed|min:3',
      'company_name' => 'string|nullable',
    ];
  }
}
