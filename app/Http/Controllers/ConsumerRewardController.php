<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsumerReward\RewardRedeemRequest;
use App\Services\CompanyService;
use App\Services\ConsumerPickupService;
use App\Services\ConsumerRewardService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class ConsumerRewardController extends Controller
{
  use JsonResponseTrait;

  protected $consumerRewardService;
  protected $companyService;
  protected $consumerPickupService;

  public function __construct(ConsumerRewardService $consumerRewardService, CompanyService $companyService, ConsumerPickupService $consumerPickupService)
  {
    $this->consumerRewardService = $consumerRewardService;
    $this->companyService = $companyService;
    $this->consumerPickupService = $consumerPickupService;
  }

  public function getPoints()
  {
    try {
      $user = auth()->user();
      $points_response = $this->consumerRewardService->getPoints($user);
      return $this->successResponse($points_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Points Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'POINTS_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function getPointsHistory()
  {
    try {
      $user = auth()->user();
      $points_history_response = $this->consumerRewardService->getPointsHistory($user);
      $pickup_history_response = $this->consumerPickupService->getPickupsHistory($points_history_response['data']);

      return $this->successResponse($pickup_history_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Points History Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'POINTS_HISTORY_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function get()
  {
    try {
      $rewards_response = $this->consumerRewardService->getRewards();
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
      $reward_response = $this->consumerRewardService->getReward($rewardId);
      $reward = $reward_response['data'];

      $company_response = $this->companyService->getCompany(null, $reward['company_id']);
      $company = $company_response['data'];

      return $this->successResponse(array_merge($reward, $company));
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Reward Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REWARD_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function getRedeems()
  {
    try {
      $user = auth()->user();
      $redeemed_response = $this->consumerRewardService->getRedeemedRewards($user);
      return $this->successResponse($redeemed_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Redeemed Rewards Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REDEEMED_REWARDS_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function getRedeem($redeemId)
  {
    try {
      $redeemed_response = $this->consumerRewardService->getRedeemedReward($redeemId);
      $redeem = $redeemed_response['data'];

      $company_response = $this->companyService->getCompany(null, $redeem['reward']['company_id']);
      $company = $company_response['data'];

      return $this->successResponse(array_merge($redeem, $company));
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Redeemed Reward Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REDEEMED_REWARD_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function redeem(RewardRedeemRequest $request, $rewardId)
  {
    try {
      $reward_response = $this->consumerRewardService->redeemReward($rewardId, $request->validated());

      $notify = [
        'title' => 'Reward Redeemed',
        'description' => 'Reward redeemed successfully',
      ];
      return $this->successResponse($reward_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Reward Redeem Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REWARD_REDEEM_ERROR', [$e->getMessage()]);
    }
  }

  public function use($redeemId)
  {
    try {
      $reward_response = $this->consumerRewardService->useReward($redeemId);

      $notify = [
        'title' => 'Reward Used',
        'description' => 'Reward used successfully',
      ];
      return $this->successResponse($reward_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Reward Use Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'REWARD_USE_ERROR', [$e->getMessage()]);
    }
  }
}
