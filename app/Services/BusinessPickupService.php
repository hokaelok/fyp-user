<?php

namespace App\Services;

use GuzzleHttp\Client;

class BusinessPickupService
{
  public function createPickup($data)
  {
    $client = new Client();
    $pickup_request = $client->post('http://localhost:8001/api/business/pickup/create', [
      'json' => $data
    ]);

    if ($pickup_request->getStatusCode() !== 201) {
      throw new \Exception('Pickup request failed');
    }
    return json_decode($pickup_request->getBody()->getContents(), true);
  }

  public function getPickups($type, $id)
  {
    $client = new Client();
    $url = 'http://localhost:8001/api/business/pickups';
    if ($type && $id) {
      $url .= '?type=' . $type . '&id=' . $id;
    }

    $pickups_request = $client->get($url);

    if ($pickups_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to get pickups');
    }

    return json_decode($pickups_request->getBody()->getContents(), true);
  }

  public function getPickup($pickupId)
  {
    $client = new Client();
    $pickup_request = $client->get('http://localhost:8001/api/business/pickup/' . $pickupId);
    if ($pickup_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to update pickup');
    }

    return json_decode($pickup_request->getBody()->getContents(), true);
  }

  public function updatePickup($pickupId, $data)
  {
    $client = new Client();
    $pickup_request = $client->post('http://localhost:8001/api/business/pickup/update/' . $pickupId, [
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
    $pickup_request = $client->get('http://localhost:8001/api/business/pickup/bookedSlots/' . $branchId);

    if ($pickup_request->getStatusCode() !== 200) {
      throw new \Exception('Failed to get booked slots');
    }
    return json_decode($pickup_request->getBody()->getContents(), true);
  }
}
