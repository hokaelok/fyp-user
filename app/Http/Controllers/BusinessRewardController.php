<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessReward\RewardCreateRequest;
use App\Http\Requests\BusinessReward\RewardUpdateRequest;
use App\Services\BusinessRewardService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class BusinessRewardController extends Controller
{
  use JsonResponseTrait;

  protected $businessRewardService;

  public function __construct(BusinessRewardService $businessRewardService)
  {
    $this->businessRewardService = $businessRewardService;
  }

  public function store(RewardCreateRequest $request)
  {
    try {
      $reward_response = $this->businessRewardService->createReward($request->validated());

      $notify = [
        'title' => 'Reward Created',
        'description' => 'Reward created successfully',
      ];
      return $this->successResponse($reward_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Reward Creation Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REWARD_CREATION_ERROR', [$e->getMessage()]);
    }
  }

  public function get(Request $request)
  {
    try {
      $company_id = $request->query('companyId');
      $rewards_response = $this->businessRewardService->getRewards($company_id);

      return $this->successResponse($rewards_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Rewards Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REWARDS_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function show($rewardId)
  {
    try {
      $reward_response = $this->businessRewardService->getReward($rewardId);
      return $this->successResponse($reward_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Reward Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REWARD_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function update(RewardUpdateRequest $request, $rewardId)
  {
    try {
      $reward_response = $this->businessRewardService->updateReward($request->validated(), $rewardId);

      $notify = [
        'title' => 'Reward Updated',
        'description' => 'Reward updated successfully',
      ];
      return $this->successResponse($reward_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Reward Update Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REWARD_UPDATE_ERROR', [$e->getMessage()]);
    }
  }
}
