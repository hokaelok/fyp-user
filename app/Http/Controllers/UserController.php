<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ProfileUpdateRequest;
use App\Services\UserService;
use App\Traits\JsonResponseTrait;

class UserController extends Controller
{
    use JsonResponseTrait;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show()
    {
        $user = auth()->user()->load('address');
        return $this->successResponse($user, null);
    }

    public function update(ProfileUpdateRequest $request)
    {
        try {
            $user = $this->userService->updateUserProfile(auth()->user(), $request->validated());

            $notify = [
                'title' => 'Profile Update Successful',
                'description' => 'Profile updated successfully',
            ];
            return $this->successResponse($user, $notify);
        } catch (\Exception $e) {
            $notify = [
                'title' => 'Profile Update Failed',
                'description' => 'An error occurred while updating the profile.',
            ];
            return $this->errorResponse($notify, 'PROFILE_UPDATE_ERROR', [$e->getMessage()]);
        }
    }

    public function deleteAddress()
    {
        $user = auth()->user();
        $user->address()->delete();

        $notify = [
            'title' => 'Address Delete Successful',
            'description' => 'Address deleted successfully',
        ];
        return $this->successResponse(null, $notify);
    }
}
