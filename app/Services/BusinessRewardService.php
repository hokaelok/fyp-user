<?php

namespace App\Services;

use GuzzleHttp\Client;

class BusinessRewardService
{
  public function createReward($data)
  {
    $client = new Client();
    $reward_request = $client->post('http://localhost:8002/api/business/reward/create', [
      'json' => $data
    ]);

    if ($reward_request->getStatusCode() !== 201) {
      throw new \Exception('Reward creation failed');
    }
    return json_decode($reward_request->getBody()->getContents(), true);
  }

  public function getRewards($company_id)
  {
    $client = new Client();
    $reward_request = $client->get('http://localhost:8002/api/business/rewards?company_id=' . $company_id);

    if ($reward_request->getStatusCode() !== 200) {
      throw new \Exception('Reward fetch failed');
    }
    return json_decode($reward_request->getBody()->getContents(), true);
  }

  public function getReward($rewardId)
  {
    $client = new Client();
    $reward_request = $client->get('http://localhost:8002/api/business/reward/' . $rewardId);

    if ($reward_request->getStatusCode() !== 200) {
      throw new \Exception('Reward fetch failed');
    }
    return json_decode($reward_request->getBody()->getContents(), true);
  }

  public function updateReward($data, $rewardId)
  {
    $client = new Client();
    $reward_request = $client->post('http://localhost:8002/api/business/reward/update/' . $rewardId, [
      'json' => $data
    ]);

    if ($reward_request->getStatusCode() !== 200) {
      throw new \Exception('Reward update failed');
    }
    return json_decode($reward_request->getBody()->getContents(), true);
  }
}
