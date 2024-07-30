<?php

namespace App\Http\Requests\ConsumerPickup;

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
      'branch_id' => 'required|integer',
      'contact_number' => 'required|string|max:15',
      'waste_payload.*.id' => 'required|integer',
      'waste_payload.*.label' => 'required|string',
      'waste_payload.*.quantity' => 'required|integer|min:1',
      'request_pickup_time' => 'required|string',
      'city' => 'required|string|max:255',
      'state' => 'required|string|max:255',
      'street' => 'required|string|max:255',
      'zip' => 'required|string|max:10',
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
    ];
  }
}
