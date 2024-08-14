<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        if (!$clientStatus) {
            return view('unavailable');
        }

        $summonerInfo = $this->lcuApiService->getSummonerInfo();
        $championSkins = $this->communityDragonService->getChampionSkins();

        return view(
            'index',
            [
                'summonerInfo' => $summonerInfo,
                'championSkins' => $championSkins
            ]
        );
    }
}
