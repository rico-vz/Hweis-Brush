<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class WindowsProcessService
{
    public function isProcessRunning(string $processName): bool
    {
        $result = Process::run("wmic process where name='{$processName}' get processid");
        return $result->successful() && count(explode("\n", $result->output())) > 2;
    }

    public function getProcessCommandLine(string $processName): ?string
    {
        $result = Process::run("wmic process where name='{$processName}' get commandline");
        
        if (!$result->successful()) {
            Log::error("Failed to get command line for process: {$processName}", [
                'error' => $result->errorOutput()
            ]);
            return null;
        }

        $output = $this->cleanOutput($result->output());
        $lines = explode("\n", $output);

        return $lines[1] ?? null;
    }

    private function cleanOutput(string $output): string
    {
        // Convert UTF-16LE to UTF-8
        $output = mb_convert_encoding($output, 'UTF-8', 'UTF-16LE');
        
        // Remove null characters
        $output = str_replace("\0", '', $output);

        // Remove surrounding quotes
        if (substr($output, 0, 1) === '"' && substr($output, -1) === '"') {
            $output = substr($output, 1, -1);
        }

        // Remove extra quotes
        $output = preg_replace('/"\s+"/', ' ', $output);
        
        // Trim each line and remove empty lines
        $lines = array_filter(array_map('trim', explode("\n", $output)));
        
        return implode("\n", $lines);
    }
}