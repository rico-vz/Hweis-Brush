<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\LcuApiService;
use App\Services\LeagueClientService;

class ProcessController extends Controller
{
    protected $leagueClientService;
    protected $lcuApiService;

    public function __construct(LeagueClientService $leagueClientService, LcuApiService $lcuApiService)
    {
        $this->leagueClientService = $leagueClientService;
        $this->lcuApiService = $lcuApiService;
    }

    public function getClientStatus(): JsonResponse
    {
        if ($this->leagueClientService->isClientRunning()) {
            $clientInfo = $this->leagueClientService->getClientInfo();
            return response()->json([
                'status' => 'running',
                'clientInfo' => $clientInfo
            ]);
        }

        return response()->json(['status' => 'not running']);
    }

    public function getSummonerInfo(): JsonResponse
    {
        $response = $this->lcuApiService->getSummonerInfo();

        return response()->json($response);
    }

    public function setBackgroundImage(int $skinId): JsonResponse
    {
        $response = $this->lcuApiService->setProfileBackground($skinId);

        return response()->json($response);
    }
}
