<?php

namespace App\Http\Requests\ConsumerReward;

use Illuminate\Foundation\Http\FormRequest;

class RewardRedeemRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'user_id' => 'required|integer',
    ];
  }
}
