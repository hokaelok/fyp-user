<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessPickup\PickupCreateRequest;
use App\Http\Requests\BusinessPickup\PickupUpdateRequest;
use App\Services\BusinessPickupService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class BusinessPickupController extends Controller
{
  use JsonResponseTrait;

  protected $businessPickupService;

  public function __construct(BusinessPickupService $businessPickupService)
  {
    $this->businessPickupService = $businessPickupService;
  }

  public function store(PickupCreateRequest $request)
  {
    try {
      $pickup_request = $this->businessPickupService->createPickup($request->validated());

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
      $pickups_request = $this->businessPickupService->getPickups($type, $id);

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
      $pickup_request = $this->businessPickupService->getPickup($pickupId);
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
      $pickup_request = $this->businessPickupService->updatePickup($pickupId, $request->validated());

      $notify = [
        'title' => 'Pickup Update Success',
        'description' => 'Pickup has been updated',
      ];
      return $this->successResponse($pickup_request['data'], $notify);
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
      $booked_slots = $this->businessPickupService->getBookedSlots($branchId);
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
