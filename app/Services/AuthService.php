<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class AuthService
{
  public function registerUser($data)
  {
    DB::beginTransaction();

    try {
      $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'country' => $data['country'],
        'user_type' => $data['user_type'],
        'password' => Hash::make($data['password']),
      ]);

      if ($data['user_type'] === 'consumer') {
        $client = new Client();
        $reward_request = $client->post('http://localhost:8002/api/points/create', [
          'json' => [
            'user_id' => $user->id,
          ]
        ]);

        if ($reward_request->getStatusCode() !== 201) {
          throw new \Exception('Consumer reward account creation failed');
        }
      }

      if (in_array($data['user_type'], ['business', 'collector'])) {
        $client = new Client();
        $company_request = $client->post('http://localhost:8001/api/company/create', [
          'json' => [
            'owner_id' => $user->id,
            'company_name' => $data['company_name'],
            'branch_type' => $data['user_type'],
          ]
        ]);

        if ($company_request->getStatusCode() !== 201) {
          throw new \Exception('Company creation failed');
        }
      }

      DB::commit();
      return $user;
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
  }

  public function loginUser($data)
  {
    $user = User::where('email', $data['email'])->first();
    if (!$user || !Hash::check($data['password'], $user->password)) {
      return null;
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return ['token' => $token];
  }
}
