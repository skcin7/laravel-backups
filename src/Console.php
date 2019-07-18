<?php

namespace skcin7\LaravelDbBackup;

use Symfony\Component\Process\Process;

/**
 * Class Console
 * @package skcin7\LaravelDbBackup
 */
class Console
{
    /**
     * @param $command
     * @return bool
     */
    public function run($command)
    {
        $process = new Process($command);
        $process->setTimeout(999999999);
        $process->run();

        if ($process->isSuccessful()) {
            return true;
        }

        return $process->getErrorOutput();
    }
}
