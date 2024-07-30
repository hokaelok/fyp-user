<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
  public function updateUserProfile($user, $data)
  {
    DB::beginTransaction();
    try {
      if (isset($data['new_password']) && Hash::check($data['password'], $user->password)) {
        $data['password'] = Hash::make($data['new_password']);
      }

      $user->fill($data);
      $user->save();

      if (isset($data['address'])) {
        $user->address()->updateOrCreate([], $data['address']);
      }

      DB::commit();
      return $user;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }
}
