<?php

use Symfony\Component\Process\Process;

if (!function_exists('runnerHelper')) {
    function runnerHelper(string $className, string $methodName, array $parameters = []): ?int
    {
        $scriptPath = base_path('background_job_runner.php');
        $paramsJson = json_encode($parameters);
        // Config params
        $retries = config('background_jobs.retries');
        $retryDelay = config('background_jobs.retry_delay');

        $command = sprintf(
            'php %s, %s, %s, %s',
            escapeshellarg($scriptPath),
            escapeshellarg($className),
            escapeshellarg($methodName),
            escapeshellarg($paramsJson)
        );


        $retryCount = 0;

        do {
            try {
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // Windows: Run as background process
                    $process = new Process(['start', '/B', 'cmd.exe', '/C', $command]);
                } else {
                    // Unix: Run as background process
                    $process = new Process([$command . ' > /dev/null 2>&1 &']);
                }

                $process->start();

                file_put_contents('../job_logs.log', "[" . date('Y-m-d H:i:s') . "] INFO: Started $className::$methodName.\n", FILE_APPEND);

                return true;

            } catch (Exception $e) {
                $retryCount++;
                file_put_contents(
                    'background_jobs_errors.log',
                    "[" . date('Y-m-d H:i:s') . "] ERROR: Retry $retryCount for $className::$methodName failed: " . $e->getMessage() . "\n",
                    FILE_APPEND
                );

                sleep($retryDelay);
            }
        } while ($retryCount < $retries);

        return false;
    }
}
