<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\StatusCode;
use App\Services\AuthService;
use App\Services\UserService;
use App\Traits\JsonResponseTrait;

class AuthController extends Controller
{
  use JsonResponseTrait;

  protected $authService;
  protected $userService;

  public function __construct(AuthService $authService, UserService $userService)
  {
    $this->authService = $authService;
    $this->userService = $userService;
  }

  public function register(RegisterRequest $request)
  {
    try {
      $user = $this->authService->registerUser($request->validated());

      $notify = [
        'title' => 'Registration Successful',
        'description' => 'User registered successfully',
      ];
      return $this->successResponse(null, $notify, StatusCode::CREATED);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Registration Failed',
        'description' => 'An error occurred while registering user and company.',
      ];
      return $this->errorResponse($notify, 'REGISTRATION_ERROR', [$e->getMessage()]);
    }
  }

  public function login(LoginRequest $request)
  {
    $result = $this->authService->loginUser($request->validated());
    if (!$result) {
      $notify = [
        'title' => 'Login Failed',
        'description' => 'Invalid credentials',
      ];
      return $this->errorResponse($notify, 'AUTHENTICATION_FAILED', null, 401);
    }

    $notify = [
      'title' => 'Login Successful',
      'description' => 'Logged in successfully',
    ];
    return $this->successResponse($result, $notify);
  }

  public function logout()
  {
    $user = auth()->user();
    $user->tokens()->delete();

    $notify = [
      'title' => 'Logout Successful',
      'description' => 'Logged out successfully',
    ];
    return $this->successResponse(null, $notify);
  }
}
