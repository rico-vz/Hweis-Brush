<?php

namespace App\Http\Controllers;

use App\Services\LeagueClientService;
use App\Services\LcuApiService;
use App\Services\CommunityDragonService;


class PageController extends Controller
{
    protected $leagueClientService;
    protected $lcuApiService;
    protected $communityDragonService;

    public function __construct(LeagueClientService $leagueClientService, LcuApiService $lcuApiService, CommunityDragonService $communityDragonService)
    {
        $this->leagueClientService = $leagueClientService;
        $this->lcuApiService = $lcuApiService;
        $this->communityDragonService = $communityDragonService;
    }

    public function index()
    {
        $clientStatus = $this->leagueClientService->isClientRunning();
        $clientInfo   = $this->leagueClientService->getClientInfo();

        if (!$clientStatus || !$clientInfo) {
            return view('unavailable');
        }

        $summonerInfo = $this->lcuApiService->getSummonerInfo();
        $championSkins = $this->communityDragonService->getChampionSkins();

        if ($summonerInfo['status'] === 'failed' || $championSkins['status'] === 'failed') {
            return view('unavailable');
        }

        return view(
            'index',
            [
                'summonerInfo' => $summonerInfo['data'],
                'championSkins' => $championSkins['data']
            ]
        );
    }
}
