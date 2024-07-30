<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'company_id' => 'required|integer',
      'name' => 'required|string|max:255',
      'image' => 'required|string|max:2048',
      'description' => 'required|string',
      'start_time' => 'required|date',
      'end_time' => 'required|date',
      'street' => 'required|string|max:255',
      'city' => 'required|string|max:255',
      'state' => 'required|string',
      'zip' => 'required|string|max:10',
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
    ];
  }
}