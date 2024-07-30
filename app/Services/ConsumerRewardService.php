<?php

namespace App\Services;

use GuzzleHttp\Client;

class ConsumerRewardService
{
  public function getPoints($user)
  {
    $client = new Client();
    $points_request = $client->get('http://localhost:8002/api/points/' . $user->id);

    if ($points_request->getStatusCode() !== 200) {
      throw new \Exception('Points fetch failed');
    }
    return json_decode($points_request->getBody()->getContents(), true);
  }

  public function getPointsHistory($user)
  {
    $client = new Client();
    $points_request = $client->get('http://localhost:8002/api/points/history/' . $user->id);

    if ($points_request->getStatusCode() !== 200) {
      throw new \Exception('Points fetch failed');
    }
    return json_decode($points_request->getBody()->getContents(), true);
  }

  public function updatePoints($data, $userId)
  {
    $client = new Client();
    $points_request = $client->post('http://localhost:8002/api/points/update/' . $userId, [
      'json' => $data
    ]);

    if ($points_request->getStatusCode() !== 200) {
      throw new \Exception('Points update failed');
    }
    return json_decode($points_request->getBody()->getContents(), true);
  }

  public function getRewards()
  {
    $client = new Client();
    $rewards_request = $client->get('http://localhost:8002/api/rewards');

    if ($rewards_request->getStatusCode() !== 200) {
      throw new \Exception('Reward fetch failed');
    }
    return json_decode($rewards_request->getBody()->getContents(), true);
  }

  public function getReward($rewardId)
  {
    $client = new Client();
    $reward_request = $client->get('http://localhost:8002/api/reward/' . $rewardId);

    if ($reward_request->getStatusCode() !== 200) {
      throw new \Exception('Reward fetch failed');
    }
    return json_decode($reward_request->getBody()->getContents(), true);
  }

  public function getRedeemedRewards($user)
  {
    $client = new Client();
    $redeemed_request = $client->get('http://localhost:8002/api/rewards/redeemed/' . $user->id);

    if ($redeemed_request->getStatusCode() !== 200) {
      throw new \Exception('Redeemed rewards fetch failed');
    }
    return json_decode($redeemed_request->getBody()->getContents(), true);
  }

  public function getRedeemedReward($redeemId)
  {
    $client = new Client();
    $redeemed_request = $client->get('http://localhost:8002/api/reward/redeemed/' . $redeemId);

    if ($redeemed_request->getStatusCode() !== 200) {
      throw new \Exception('Redeemed reward fetch failed');
    }
    return json_decode($redeemed_request->getBody()->getContents(), true);
  }

  public function redeemReward($rewardId, $data)
  {
    $client = new Client();
    $reward_request = $client->post('http://localhost:8002/api/reward/redeem/' . $rewardId, [
      'json' => $data
    ]);

    if ($reward_request->getStatusCode() !== 200) {
      throw new \Exception('Reward redeem failed');
    }
    return json_decode($reward_request->getBody()->getContents(), true);
  }

  public function useReward($redeemId)
  {
    $client = new Client();
    $reward_request = $client->post('http://localhost:8002/api/reward/use/' . $redeemId);

    if ($reward_request->getStatusCode() !== 200) {
      throw new \Exception('Reward use failed');
    }
    return json_decode($reward_request->getBody()->getContents(), true);
  }
}
