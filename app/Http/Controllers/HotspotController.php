<?php

namespace App\Http\Controllers;

use App\Services\HotspotService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class HotspotController extends Controller
{
  use JsonResponseTrait;

  protected $hotspotService;

  public function __construct(HotspotService $hotspotService)
  {
    $this->hotspotService = $hotspotService;
  }

  public function get()
  {
    try {
      $hotspot_response = $this->hotspotService->getHotspots();
      return $this->successResponse($hotspot_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Hotspot Fetch Failed',
        'description' => 'Failed to fetch hotspots',
      ];
      return $this->errorResponse($notify, 'HOTSPOTS_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function show(Request $request)
  {
    try {
      $id = $request->query('id');
      $type = $request->query('type');
      $hotspot_response = $this->hotspotService->getHotspot($id, $type);

      return $this->successResponse($hotspot_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Hotspot Fetch Failed',
        'description' => 'Failed to fetch hotspot',
      ];
      return $this->errorResponse($notify, 'HOTSPOT_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function getBiz()
  {
    try {
      $hotspot_response = $this->hotspotService->getBusinessHotspots();
      return $this->successResponse($hotspot_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Hotspot Fetch Failed',
        'description' => 'Failed to fetch business hotspots',
      ];
      return $this->errorResponse($notify, 'HOTSPOTS_FETCH_ERROR', [$e->getMessage()]);
    }
  }

  public function showBiz($hotspotId)
  {
    try {
      $hotspot_response = $this->hotspotService->getBusinessHotspot($hotspotId);

      return $this->successResponse($hotspot_response['data']);
    } catch (\Exception $e) {
      $notify = [
        'title' => 'Hotspot Fetch Failed',
        'description' => 'Failed to fetch business hotspot',
      ];
      return $this->errorResponse($notify, 'HOTSPOT_FETCH_ERROR', [$e->getMessage()]);
    }
  }
}
