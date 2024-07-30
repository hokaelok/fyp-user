<?php

namespace App\Services;

use App\Http\StatusCode;
use GuzzleHttp\Client;

class CompanyService
{
  public function getCompany($user = null, $companyId = null)
  {
    if (!$user && !$companyId) {
      throw new \Exception('User or Company ID must be provided');
    }

    $client = new Client();

    $query = [];
    if ($user && $user->id) {
      $query['owner_id'] = $user->id;
    }
    if ($companyId) {
      $query['company_id'] = $companyId;
    }

    $company_request = $client->get('http://localhost:8001/api/company', [
      'query' => $query
    ]);

    if ($company_request->getStatusCode() !== 200) {
      throw new \Exception('Company fetch failed');
    }
    return json_decode($company_request->getBody()->getContents(), true);
  }

  public function updateCompany($user, $data)
  {
    $client = new Client();
    $company_request = $client->post('http://localhost:8001/api/company/update', [
      'json' => [
        'owner_id' => $user->id,
        'company_id' => $data['id'],
        'name' => $data['name'],
        'email' => $data['email'],
        'logo' => $data['logo'],
        'phone' => $data['phone'],
        'open_time' => $data['businessStartHour'],
        'close_time' => $data['businessEndHour'],
        'website' => $data['websiteUrl'],
        'street' => $data['street'],
        'city' => $data['city'],
        'state' => $data['state'],
        'zip' => $data['zip'],
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude'],
      ]
    ]);
    if ($company_request->getStatusCode() === StatusCode::INTERNAL_SERVER_ERROR) {
      throw new \Exception('Company creation failed');
    }

    return json_decode($company_request->getBody()->getContents(), true);
  }
}
