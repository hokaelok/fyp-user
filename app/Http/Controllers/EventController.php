<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Services\EventService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class EventController extends Controller
{
  use JsonResponseTrait;

  protected $eventService;

  public function __construct(EventService $eventService)
  {
    $this->eventService = $eventService;
  }

  public function store(EventCreateRequest $request)
  {
    try {
      $user = $request->user();
      $event_response = $this->eventService->createEvent($user, $request->validated());

      $notify = [
        'title' => 'Event Created',
        'description' => 'Event has been created successfully',
      ];
      return $this->successResponse($event_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Event Creation Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'EVENT_CREATION_ERROR', [$e->getMessage()]);
    }
  }

  public function get(Request $request)
  {
    try {
      $company_id = $request->query('company_id');
      $event_response = $this->eventService->getEvents($company_id);

      $notify = [
        'title' => 'Events Fetched',
        'description' => 'Events have been fetched successfully',
      ];
      return $this->successResponse($event_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Events Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'EVENT_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function show($eventId)
  {
    try {
      $event_response = $this->eventService->getEvent($eventId);

      $notify = [
        'title' => 'Event Fetched',
        'description' => 'Event has been fetched successfully',
      ];
      return $this->successResponse($event_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Event Fetch Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'EVENT_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function update(EventUpdateRequest $request, $eventId)
  {
    try {
      $user = $request->user();
      $event_response = $this->eventService->updateEvent($user, $eventId, $request->validated());

      $notify = [
        'title' => 'Event Updated',
        'description' => 'Event has been updated successfully',
      ];
      return $this->successResponse($event_response['data'], $notify);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Event Update Failed',
        'description' => 'An error occurred',
      ];
      return $this->errorResponse($notify, 'EVENT_UPDATE_ERROR', [$e->getMessage()]);
    }
  }
}
