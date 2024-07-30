<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BusinessPickupController;
use App\Http\Controllers\BusinessRewardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConsumerPickupController;
use App\Http\Controllers\ConsumerRewardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::get('user', [UserController::class, 'show']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::post('user/address/delete', [UserController::class, 'deleteAddress']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Hotspot
    Route::get('hotspots', [HotspotController::class, 'get']);
    Route::get('hotspot', [HotspotController::class, 'show']);
    Route::get('business/hotspots', [HotspotController::class, 'getBiz']);
    Route::get('business/hotspot/{hotspotId}', [HotspotController::class, 'showBiz']);

    // Pickup
    Route::get('pickups', [ConsumerPickupController::class, 'get']);
    Route::post('pickup/create', [ConsumerPickupController::class, 'store']);
    Route::get('pickup/{pickupId}', [ConsumerPickupController::class, 'show']);
    Route::post('pickup/update/{pickupId}', [ConsumerPickupController::class, 'update']);
    Route::get('pickup/bookedSlots/{branchId}', [ConsumerPickupController::class, 'getBookedSlots']);

    // Business Pickup 
    Route::get('business/pickups', [BusinessPickupController::class, 'get']);
    Route::post('business/pickup/create', [BusinessPickupController::class, 'store']);
    Route::get('business/pickup/{pickupId}', [BusinessPickupController::class, 'show']);
    Route::post('business/pickup/update/{pickupId}', [BusinessPickupController::class, 'update']);
    Route::get('business/pickup/bookedSlots/{branchId}', [BusinessPickupController::class, 'getBookedSlots']);

    // Company
    Route::get('company', [CompanyController::class, 'show']);
    Route::post('company/update', [CompanyController::class, 'update']);

    // Branch
    Route::get('branches', [BranchController::class, 'get']);
    Route::post('branch/create', [BranchController::class, 'store']);
    Route::get('branch/{branchId}', [BranchController::class, 'show']);
    Route::post('branch/update/{branchId}', [BranchController::class, 'update']);

    // File
    Route::post('file/create', [FileController::class, 'create']);
    Route::get('file/read/{key}', [FileController::class, 'read']);
    Route::put('file/update/{key}', [FileController::class, 'update']);
    Route::delete('file/delete/{key}', [FileController::class, 'delete']);

    // Points
    Route::get('points', [ConsumerRewardController::class, 'getPoints']);
    Route::get('points/history', [ConsumerRewardController::class, 'getPointsHistory']);

    // Reward
    Route::get('rewards', [ConsumerRewardController::class, 'get']);
    Route::get('reward/{rewardId}', [ConsumerRewardController::class, 'show']);
    Route::get('rewards/redeemed', [ConsumerRewardController::class, 'getRedeems']);
    Route::get('reward/redeemed/{redeemId}', [ConsumerRewardController::class, 'getRedeem']);
    Route::post('reward/redeem/{redeemId}', [ConsumerRewardController::class, 'redeem']);
    Route::post('reward/use/{redeemId}', [ConsumerRewardController::class, 'use']);

    // Business Reward
    Route::get('business/rewards', [BusinessRewardController::class, 'get']);
    Route::post('business/reward/create', [BusinessRewardController::class, 'store']);
    Route::get('business/reward/{rewardId}', [BusinessRewardController::class, 'show']);
    Route::post('business/reward/update/{rewardId}', [BusinessRewardController::class, 'update']);

    // Event
    Route::get('events', [EventController::class, 'get']);
    Route::post('event/create', [EventController::class, 'store']);
    Route::get('event/{eventId}', [EventController::class, 'show']);
    Route::post('event/update/{eventId}', [EventController::class, 'update']);
});
