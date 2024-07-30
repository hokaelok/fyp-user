<?php

namespace App\Services;

use GuzzleHttp\Client;

class HotspotService
{
  public function getHotspots()
  {
    $client = new Client();
    $response = $client->get('http://localhost:8001/api/hotspots');

    if ($response->getStatusCode() !== 200) {
      throw new \Exception('Failed to fetch hotspots');
    }
    return json_decode($response->getBody()->getContents(), true);
  }

  public function getHotspot($id, $type)
  {
    $client = new Client();
    $response = $client->get('http://localhost:8001/api/hotspot', [
      'query' => [
        'id' => $id,
        'type' => $type,
      ]
    ]);

    if ($response->getStatusCode() !== 200) {
      throw new \Exception('Failed to fetch hotspot');
    }
    return json_decode($response->getBody()->getContents(), true);
  }

  public function getBusinessHotspots()
  {
    $client = new Client();
    $response = $client->get('http://localhost:8001/api/business/hotspots');

    if ($response->getStatusCode() !== 200) {
      throw new \Exception('Failed to fetch business hotspots');
    }
    return json_decode($response->getBody()->getContents(), true);
  }

  public function getBusinessHotspot($hotspotId)
  {
    $client = new Client();
    $response = $client->get('http://localhost:8001/api/business/hotspot/' . $hotspotId);

    if ($response->getStatusCode() !== 200) {
      throw new \Exception('Failed to fetch business hotspot');
    }
    return json_decode($response->getBody()->getContents(), true);
  }
}
