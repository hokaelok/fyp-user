<?php

namespace App\Http\Requests\BusinessReward;

use Illuminate\Foundation\Http\FormRequest;

class RewardCreateRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'company_id' => 'required|integer',
      'image' => 'required|string|max:255',
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'required_points' => 'required|integer',
      'start_time' => 'required|string',
      'end_time' => 'required|string',
      'expiry_time' => 'required|string',
    ];
  }
}
