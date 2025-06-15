<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class WindowsProcessService
{
    public function isProcessRunning(string $processName): bool
    {
        $command = "powershell -Command \"Get-CimInstance -ClassName Win32_Process -Filter \\\"Name='$processName'\\\" | Select-Object ProcessId | ConvertTo-Json\"";
        $result = Process::run($command);

        if (!$result->successful()) {
            Log::error("Failed to check if process is running: {$processName}", [
                'error' => $result->errorOutput()
            ]);
            return false;
        }

        $output = trim($result->output());

        if (empty($output) || $output === 'null') {
            return false;
        }

        $processes = json_decode($output, true);
        return !empty($processes);
    }

    public function getProcessCommandLine(string $processName): ?string
    {
        $command = "powershell -Command \"Get-CimInstance -ClassName Win32_Process -Filter \\\"Name='$processName'\\\" | Select-Object CommandLine | ConvertTo-Json\"";
        $result = Process::run($command);

        if (!$result->successful()) {
            Log::error("Failed to get command line for process: {$processName}", [
                'error' => $result->errorOutput()
            ]);
            return null;
        }

        $output = trim($result->output());

        if (empty($output) || $output === 'null') {
            return null;
        }

        $processes = json_decode($output, true);

        if (isset($processes['CommandLine'])) {
            return $processes['CommandLine'];
        } elseif (is_array($processes) && !empty($processes)) {
            return $processes[0]['CommandLine'] ?? null;
        }

        return null;
    }
}
