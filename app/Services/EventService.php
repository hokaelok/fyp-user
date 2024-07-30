<?php

namespace App\Services;

use GuzzleHttp\Client;

class EventService
{
  public function createEvent($user, $data)
  {
    $client = new Client();
    $event_request = $client->post('http://localhost:8001/api/event/create', [
      'json' => [
        'user_id' => $user->id,
        'company_id' => $data['company_id'],
        'name' => $data['name'],
        'image' => $data['image'],
        'description' => $data['description'],
        'start_time' => $data['start_time'],
        'end_time' => $data['end_time'],
        'street' => $data['street'],
        'city' => $data['city'],
        'state' => $data['state'],
        'zip' => $data['zip'],
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude'],
      ]
    ]);

    if ($event_request->getStatusCode() !== 201) {
      throw new \Exception('Event creation failed');
    }
    return json_decode($event_request->getBody()->getContents(), true);
  }

  public function getEvents($company_id)
  {
    $client = new Client();
    $event_request = $client->get('http://localhost:8001/api/events?company_id=' . $company_id);

    if ($event_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to fetch events');
    }
    return json_decode($event_request->getBody()->getContents(), true);
  }

  public function getEvent($eventId)
  {
    $client = new Client();
    $event_request = $client->get('http://localhost:8001/api/event/' . $eventId);

    if ($event_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to fetch event');
    }
    return json_decode($event_request->getBody()->getContents(), true);
  }

  public function updateEvent($user, $eventId, $data)
  {
    $client = new Client();
    $event_request = $client->post('http://localhost:8001/api/event/update/' . $eventId, [
      'json' => [
        'user_id' => $user->id,
        'company_id' => $data['company_id'],
        'name' => $data['name'],
        'image' => $data['image'],
        'description' => $data['description'],
        'start_time' => $data['start_time'],
        'end_time' => $data['end_time'],
        'street' => $data['street'],
        'city' => $data['city'],
        'state' => $data['state'],
        'zip' => $data['zip'],
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude'],
      ]
    ]);

    if ($event_request->getStatusCode() !== 200) {
      throw new \Exception('Event update failed');
    }
    return json_decode($event_request->getBody()->getContents(), true);
  }
}
