<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Services\CompanyService;
use App\Traits\JsonResponseTrait;

class CompanyController extends Controller
{
  use JsonResponseTrait;

  protected $companyService;

  public function __construct(CompanyService $companyService)
  {
    $this->companyService = $companyService;
  }

  public function show()
  {
    $user = auth()->user();

    try {
      $company_response = $this->companyService->getCompany($user);

      return $this->successResponse($company_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Company Profile Fetch Failed',
        'description' => 'An error occurred while fetching the company profile',
      ];
      return $this->errorResponse($notify, 'COMPANY_PROFILE_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function update(CompanyUpdateRequest $request)
  {
    $user = auth()->user();

    try {
      $company_response = $this->companyService->updateCompany($user, $request->validated());

      $notify = [
        'title' => 'Company Profile Updated',
        'description' => 'Company profile updated successfully',
      ];
      return $this->successResponse(null, $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Company Profile Update Failed',
        'description' => 'An error occurred while updating the company profile',
      ];
      return $this->errorResponse($notify, 'COMPANY_PROFILE_UPDATE_ERROR', [$e->getMessage()]);
    }
  }
}
