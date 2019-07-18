<?php

namespace skcin7\LaravelDbBackup\Databases;

use skcin7\LaravelDbBackup\Databases\DatabaseContract;
use skcin7\LaravelDbBackup\Console;

/**
 * Class SqliteDatabase
 * @package skcin7\LaravelDbBackup\Databases
 */
class SqliteDatabase implements DatabaseContract
{
    /**
     * @var skcin7\LaravelDbBackup\Console
     */
    protected $console;

    /**
     * @var string
     */
    protected $databaseFile;

    /**
     * @param skcin7\LaravelDbBackup\Console $destinationFile
     * @param string $databaseFile
     * @return skcin7\LaravelDbBackup\Database\SqliteDatabase
     */
    public function __construct(Console $console, $databaseFile)
    {
        $this->console = $console;
        $this->databaseFile = $databaseFile;
    }

    /**
     * Create a database dump
     *
     * @param string $destinationFile
     * @return boolean
     */
    public function dump($destinationFile)
    {
        $command = sprintf('cp %s %s',
            escapeshellarg($this->databaseFile),
            escapeshellarg($destinationFile)
        );

        return $this->console->run($command);
    }

    /**
     * Restore a database dump
     *
     * @param string $sourceFile
     * @return boolean
     */
    public function restore($sourceFile)
    {
        $command = sprintf('cp -f %s %s',
            escapeshellarg($sourceFile),
            escapeshellarg($this->databaseFile)
        );

        return $this->console->run($command);
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return 'sqlite';
    }
}