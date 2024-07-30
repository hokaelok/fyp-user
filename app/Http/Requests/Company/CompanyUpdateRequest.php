<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'id' => 'required|integer',
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'logo' => 'required|string|max:2048',
      'phone' => 'required|string|max:15',
      'websiteUrl' => 'nullable|url|max:255',
      'businessStartHour' => 'required|string|max:255',
      'businessEndHour' => 'required|string|max:255',
      'street' => 'required|string|max:255',
      'city' => 'required|string|max:255',
      'state' => 'required|string',
      'zip' => 'required|string|max:10',
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
    ];
  }
}
