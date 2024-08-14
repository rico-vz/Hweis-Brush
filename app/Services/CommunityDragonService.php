<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CommunityDragonService
{
    public function getChampionSkins()
    {
        return Cache::remember('champion_skins', 60 * 60 * 24, function () {
            $response = Http::get('https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/skins.json');
            if (!$response->successful()) {
                return $response->status();
            }
            $skins = $response->json();
            $championSkins = [];
            foreach ($skins as $skin) {
                $championName = $this->extractChampionName($skin['splashPath']);
                if (strpos($championName, 'Strawberry_') !== false) {
                    continue;
                }
                $championSkins[$championName][] = [
                    'skinId' => $skin['id'],
                    'name' => $skin['name'],
                    'splashUrl' => $this->extractChampionSplashUrl($skin['splashPath'])
                ];
            }
            ksort($championSkins);

            return $championSkins;
        });
    }

    private function extractChampionName(string $splashPath): string
    {
        return $this->extractPathSegment($splashPath, '/characters/', '/skins/');
    }

    private function extractChampionSplashUrl(string $splashPath): string
    {
        $baseUrl = 'https://raw.communitydragon.org/pbe/plugins/rcp-be-lol-game-data/global/default/assets/characters/';
        $championPath = $this->extractPathSegment($splashPath, '/characters/');

        return $baseUrl . strtolower($championPath);
    }

    private function extractPathSegment(string $path, string $startMarker, string $endMarker = null): string
    {
        $lowercasePath = strtolower($path);
        $start = strpos($lowercasePath, $startMarker) + strlen($startMarker);
        $end = $endMarker ? strpos($lowercasePath, $endMarker) : strlen($path);

        return substr($path, $start, $end - $start);
    }
}
