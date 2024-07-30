<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $userId = auth()->id();

    return [
      'name' => 'string|nullable',
      'email' => 'email|unique:users,email,' . $userId,
      'country' => 'string|size:2|nullable',
      'password' => 'nullable|string|min:3',
      'new_password' => 'nullable|string|same:new_password|min:3',
      'address.street' => 'string|nullable',
      'address.city' => 'string|nullable',
      'address.state' => 'string|nullable',
      'address.zip' => 'string|nullable',
      'address.latitude' => 'nullable|numeric',
      'address.longitude' => 'nullable|numeric',
    ];
  }
}
