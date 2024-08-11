<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class LcuApiService
{
    protected $baseUrl;
    protected $authToken;
    protected $port;

    public function __construct(LeagueClientService $leagueClientService)
    {
        $clientInfo = $leagueClientService->getClientInfo();
        if ($clientInfo) {
            $this->authToken = $clientInfo['authToken'];
            $this->port = $clientInfo['port'];
            $this->baseUrl = "https://127.0.0.1:{$this->port}";
        }
    }


    public function makeRequest(string $method, string $endpoint, array $data = []): Response
    {
        $url = $this->baseUrl . $endpoint;

        $options = [
            'verify' => false, // Don't validate the cert
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode("riot:{$this->authToken}")
            ]
        ];

        $response = match (strtoupper($method)) {
            'GET' => Http::withOptions($options)->get($url, $data),
            'POST' => Http::withOptions($options)->post($url, $data),
            'PUT' => Http::withOptions($options)->put($url, $data),
            'PATCH' => Http::withOptions($options)->patch($url, $data),
            default => throw new \InvalidArgumentException("Unsupported HTTP method: {$method}")
        };

        return $response;
    }

    public function getSummonerInfo()
    {
        $response = $this->makeRequest('GET', '/lol-summoner/v1/current-summoner');

        if ($response->successful()) {
            return $response->json();
        } else {
            return $response->status();
        }
    }
}
