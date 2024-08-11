<?php

namespace App\Services;

use App\Services\WindowsProcessService;

class LeagueClientService
{
    protected $windowsProcessService;
    protected $processName = 'LeagueClientUx.exe';

    public function __construct(WindowsProcessService $windowsProcessService)
    {
        $this->windowsProcessService = $windowsProcessService;
    }

    public function isClientRunning(): bool
    {
        return $this->windowsProcessService->isProcessRunning($this->processName);
    }

    public function getClientInfo(): ?array
    {
        if (!$this->isClientRunning()) {
            return null;
        }

        $commandLine = $this->windowsProcessService->getProcessCommandLine($this->processName);

        if (!$commandLine) {
            return null;
        }

        return [
            'authToken' => $this->extractAuthToken($commandLine),
            'port' => $this->extractPort($commandLine)
        ];
    }

    protected function extractAuthToken(string $commandLine): ?string
    {
        if (preg_match('/--remoting-auth-token=(\S+)/', $commandLine, $matches)) {
            return $matches[1];
        }
        return null;
    }

    protected function extractPort(string $commandLine): ?int
    {
        if (preg_match('/--app-port=(\d+)/', $commandLine, $matches)) {
            return (int)$matches[1];
        }
        return null;
    }
}
