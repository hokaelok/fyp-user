<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class BranchCreateRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'company_id' => 'required|integer',
      'branch_name' => 'required|string|max:255',
      'branch_email' => 'required|email|max:255',
      'branch_phone' => 'required|string|max:15',
      'branch_type' => 'required|string|in:business,collector|max:255',
      'branch_start_hour' => 'required|string|max:255',
      'branch_end_hour' => 'required|string|max:255',
      'branch_street' => 'required|string|max:255',
      'branch_city' => 'required|string|max:255',
      'branch_state' => 'required|string',
      'branch_zip' => 'required|string|max:10',
      'branch_latitude' => 'required|numeric',
      'branch_longitude' => 'required|numeric',
    ];
  }
}
