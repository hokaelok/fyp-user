<?php

namespace App\Services;

use GuzzleHttp\Client;

class BranchService
{
  public function createBranch($user, $data)
  {
    $client = new Client();
    $branch_request = $client->post('http://localhost:8001/api/branch/create', [
      'json' => [
        'user_id' => $user->id,
        'company_id' => $data['company_id'],
        'name' => $data['branch_name'],
        'email' => $data['branch_email'],
        'phone' => $data['branch_phone'],
        'branch_type' => $data['branch_type'],
        'open_time' => $data['branch_start_hour'],
        'close_time' => $data['branch_end_hour'],
        'street' => $data['branch_street'],
        'city' => $data['branch_city'],
        'state' => $data['branch_state'],
        'zip' => $data['branch_zip'],
        'latitude' => $data['branch_latitude'],
        'longitude' => $data['branch_longitude'],
      ]
    ]);

    if ($branch_request->getStatusCode() !== 201) {
      throw new \Exception('Branch creation failed');
    }

    return json_decode($branch_request->getBody()->getContents(), true);
  }

  public function getBranches($company_id)
  {
    $client = new Client();
    $branch_request = $client->get('http://localhost:8001/api/branches?company_id=' . $company_id);
    if ($branch_request->getStatusCode() !== 200) {
      throw new \Exception('Branches fetch failed');
    }

    return json_decode($branch_request->getBody()->getContents(), true);
  }

  public function getBranch($branchId)
  {
    $client = new Client();
    $branch_request = $client->get('http://localhost:8001/api/branch/' . $branchId);
    if ($branch_request->getStatusCode() !== 200) {
      throw new \Exception('Branch fetch failed');
    }

    return json_decode($branch_request->getBody()->getContents(), true);
  }

  public function updateBranch($user, $branchId, $data)
  {
    $client = new Client();
    $branch_request = $client->post('http://localhost:8001/api/branch/update/' . $branchId, [
      'json' => [
        'user_id' => $user->id,
        'name' => $data['branch_name'],
        'email' => $data['branch_email'],
        'phone' => $data['branch_phone'],
        'open_time' => $data['branch_start_hour'],
        'close_time' => $data['branch_end_hour'],
        'street' => $data['branch_street'],
        'city' => $data['branch_city'],
        'state' => $data['branch_state'],
        'zip' => $data['branch_zip'],
      ],
    ]);

    if ($branch_request->getStatusCode() !== 200) {
      throw new \Exception('Branch update failed');
    }

    return json_decode($branch_request->getBody()->getContents(), true);
  }
}
