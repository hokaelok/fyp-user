<?php

namespace App\Http\Requests\BusinessPickup;

use Illuminate\Foundation\Http\FormRequest;

class PickupCreateRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'requestor_branch_id' => 'required|integer',
      'collector_branch_id' => 'required|integer',
      'request_pickup_time' => 'required|string',
      'waste_payload.*.id' => 'required|integer',
      'waste_payload.*.label' => 'required|string',
      'waste_payload.*.quantity' => 'required|integer|min:1',
    ];
  }
}
