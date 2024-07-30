<?php

namespace App\Http\Requests\BusinessPickup;

use Illuminate\Foundation\Http\FormRequest;

class PickupUpdateRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'decision' => 'required|string|in:accept,reject,complete',
      'remark' => 'nullable|string',
    ];
  }
}
