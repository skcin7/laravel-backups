<?php

namespace skcin7\LaravelDbBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use skcin7\LaravelDbBackup\DatabaseBuilder;
use skcin7\LaravelDbBackup\ConsoleColors;
use skcin7\LaravelDbBackup\Console;

/**
 * Class BaseCommand
 * @package skcin7\LaravelDbBackup\Commands
 */
class BaseCommand extends Command
{
    /**
     * @var skcin7\LaravelDbBackup\DatabaseBuilder
     */
    protected $databaseBuilder;

    /**
     * @var skcin7\LaravelDbBackup\ConsoleColors
     */
    protected $colors;

    /**
     * @var skcin7\LaravelDbBackup\Console
     */
    protected $console;

    /**
     * @param skcin7\LaravelDbBackup\DatabaseBuilder $databaseBuilder
     * @return skcin7\LaravelDbBackup\Commands\BaseCommand
     */
    public function __construct(DatabaseBuilder $databaseBuilder)
    {
        parent::__construct();

        $this->databaseBuilder = $databaseBuilder;
        $this->colors = new ConsoleColors();
        $this->console = new Console();
    }

    /**
     * @return skcin7\LaravelDbBackup\Databases\DatabaseContract
     */
    public function getDatabase($database)
    {
        $database = $database ?: Config::get('database.default');
        $realConfig = Config::get('database.connections.' . $database);

        return $this->databaseBuilder->getDatabase($realConfig);
    }

    /**
     * @return string
     */
    protected function getDumpsPath()
    {
        return Config::get('db-backup.path');
    }

    /**
     * @return boolean
     */
    public function enableCompression()
    {
        return Config::set('db-backup.compress', true);
    }

    /**
     * @return boolean
     */
    public function disableCompression()
    {
        return Config::set('db-backup.compress', false);
    }

    /**
     * @return boolean
     */
    public function isCompressionEnabled()
    {
        return Config::get('db-backup.compress');
    }

    /**
     * @return boolean
     */
    public function isCompressed($fileName)
    {
        return pathinfo($fileName, PATHINFO_EXTENSION) === "gz";
    }
}
