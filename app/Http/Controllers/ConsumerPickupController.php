<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsumerPickup\PickupCreateRequest;
use App\Http\Requests\ConsumerPickup\PickupUpdateRequest;
use App\Services\ConsumerPickupService;
use App\Services\ConsumerRewardService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class ConsumerPickupController extends Controller
{
  use JsonResponseTrait;

  protected $consumerPickupService;
  protected $consumerRewardService;

  public function __construct(ConsumerPickupService $consumerPickupService, ConsumerRewardService $consumerRewardService)
  {
    $this->consumerPickupService = $consumerPickupService;
    $this->consumerRewardService = $consumerRewardService;
  }

  public function store(PickupCreateRequest $request)
  {
    try {
      $user = $request->user();
      $pickup_request = $this->consumerPickupService->createPickup($user, $request->validated());

      $notify = [
        'title' => 'Pickup Request Success',
        'description' => 'Pickup request has been sent',
      ];
      return $this->successResponse($pickup_request['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Pickup Request Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'PICKUP_REQUEST_ERROR', [$e->getMessage()]);
    }
  }

  public function get(Request $request)
  {
    try {
      $type = $request->query('type');
      $id = $request->query('id');
      $pickups_request = $this->consumerPickupService->getPickups($type, $id);

      return $this->successResponse($pickups_request['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Pickups Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'PICKUPS_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function show($pickupId)
  {
    try {
      $user = auth()->user();

      $pickup_request = $this->consumerPickupService->getPickup($user, $pickupId);
      return $this->successResponse($pickup_request['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Pickup Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'PICKUP_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function update(PickupUpdateRequest $request, $pickupId)
  {
    try {
      $pickup_request = $this->consumerPickupService->updatePickup($pickupId, $request->validated());
      $pickup = $pickup_request['data'];

      if ($request->validated('decision') === 'complete') {
        $this->consumerRewardService->updatePoints([
          'type' => 'earn',
          'points' => $request['points'],
          'consumer_pickup_id' => $pickup['id'],
        ], $pickup['requestor_id']);
      }

      $notify = [
        'title' => 'Pickup Update Success',
        'description' => 'Pickup has been updated',
      ];
      return $this->successResponse(null, $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Pickup Update Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'PICKUP_UPDATE_ERROR', [$e->getMessage()]);
    }
  }

  public function getBookedSlots($branchId)
  {
    try {
      $booked_slots = $this->consumerPickupService->getBookedSlots($branchId);
      return $this->successResponse($booked_slots['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Booked Slots Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'BOOKED_SLOTS_FETCH_ERROR', [$e->getMessage()]);
    }
  }
}
