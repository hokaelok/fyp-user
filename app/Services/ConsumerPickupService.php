<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\User;

class ConsumerPickupService
{
  public function createPickup($user, $data)
  {
    $client = new Client();
    $pickup_request = $client->post('http://localhost:8001/api/pickup/create', [
      'json' => array_merge($data, ['user_id' => $user->id])
    ]);

    if ($pickup_request->getStatusCode() !== 201) {
      throw new \Exception('Pickup request failed');
    }

    return json_decode($pickup_request->getBody()->getContents(), true);
  }

  public function getPickups($type, $id)
  {
    $client = new Client();
    $url = 'http://localhost:8001/api/pickups';
    if ($type && $id) {
      $url .= '?type=' . $type . '&id=' . $id;
    }

    $pickups_request = $client->get($url);
    if ($pickups_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to get pickups');
    }

    $pickups = json_decode($pickups_request->getBody()->getContents(), true);

    if ($type == 'business') {
      foreach ($pickups['data'] as &$pickup) {
        $pickup['user'] = User::find($pickup['requestor_id']);
      }
    }

    return $pickups;
  }

  public function getPickup($user, $pickupId)
  {
    $client = new Client();
    $pickup_request = $client->get('http://localhost:8001/api/pickup/' . $pickupId);
    if ($pickup_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to update pickup');
    }

    $pickup = json_decode($pickup_request->getBody()->getContents(), true);

    if ($user->user_type == 'business') {
      $pickup['data']['user'] = User::find($pickup['data']['requestor_id']);
    }

    return $pickup;
  }

  public function updatePickup($pickupId, $data)
  {
    $client = new Client();
    $pickup_request = $client->post('http://localhost:8001/api/pickup/update/' . $pickupId, [
      'json' => $data
    ]);

    if ($pickup_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to update pickup');
    }
    return json_decode($pickup_request->getBody()->getContents(), true);
  }

  public function getBookedSlots($branchId)
  {
    $client = new Client();
    $pickup_request = $client->get('http://localhost:8001/api/pickup/bookedSlots/' . $branchId);

    if ($pickup_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to get booked slots');
    }
    return json_decode($pickup_request->getBody()->getContents(), true);
  }

  public function getPickupsHistory($data)
  {
    $client = new Client();
    $pickup_request = $client->post('http://localhost:8001/api/pickups/history', [
      'json' => $data
    ]);

    if ($pickup_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to get pickup history');
    }
    return json_decode($pickup_request->getBody()->getContents(), true);
  }
}
