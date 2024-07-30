<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\BranchCreateRequest;
use App\Http\Requests\Branch\BranchUpdateRequest;
use App\Services\BranchService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class BranchController extends Controller
{
  use JsonResponseTrait;

  protected $branchService;

  public function __construct(BranchService $branchService)
  {
    $this->branchService = $branchService;
  }

  public function store(BranchCreateRequest $request)
  {
    $user = $request->user();

    try {
      $branch_response = $this->branchService->createBranch($user, $request->validated());

      $notify = [
        'title' => 'Branch Created',
        'description' => 'Branch created successfully',
      ];
      return $this->successResponse($branch_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Branch Creation Failed',
        'description' => 'An error occurred while creating the branch',
      ];
      return $this->errorResponse($notify, 'BRANCH_CREATION_ERROR', [$e->getMessage()]);
    }
  }

  public function get(Request $request)
  {
    try {
      $branch_response = $this->branchService->getBranches($request->query('company_id'));
      return $this->successResponse($branch_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Branches Fetch Failed',
        'description' => 'An error occurred while fetching branches: ' . $e->getMessage(),
      ];
      return $this->errorResponse($notify, 'BRANCH_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function show($branchId)
  {
    try {
      $branch_response = $this->branchService->getBranch($branchId);
      return $this->successResponse($branch_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Branch Fetch Failed',
        'description' => 'An error occurred while fetching the branch: ' . $e->getMessage(),
      ];
      return $this->errorResponse($notify, 'BRANCH_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function update(BranchUpdateRequest $request, $branchId)
  {
    $user = $request->user();

    try {
      $branch_response = $this->branchService->updateBranch($user, $branchId, $request->validated());
      $notify = [
        'title' => 'Branch Updated',
        'description' => 'Branch updated successfully',
      ];
      return $this->successResponse($branch_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Branch Update Failed',
        'description' => 'An error occurred while updating the branch: ' . $e->getMessage(),
      ];
      return $this->errorResponse($notify, 'BRANCH_UPDATE_ERROR', [$e->getMessage()]);
    }
  }
}
