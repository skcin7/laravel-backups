<?php

namespace skcin7\LaravelDbBackup\Databases;

use Illuminate\Support\Facades\Config;
use skcin7\LaravelDbBackup\Databases\DatabaseContract;
use skcin7\LaravelDbBackup\Console;

/**
 * Class MySQLDatabase
 * @package skcin7\LaravelDbBackup\Databases
 */
class MySQLDatabase implements DatabaseContract
{
    /**
     * @var skcin7\LaravelDbBackup\Console
     */
    protected $console;

    /**
     * @var string
     */
    protected $database;
    protected $user;
    protected $password;
    protected $host;
    protected $port;

    /**
     * @param skcin7\LaravelDbBackup\Console $destinationFile
     * @param string $database
     * @param string $user
     * @param string $password
     * @param string $host
     * @param string $port
     * @return skcin7\LaravelDbBackup\Database\MySQLDatabase
     */
    public function __construct(Console $console, $database, $user, $password, $host, $port)
    {
        $this->console = $console;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Create a database dump
     *
     * @param string $destinationFile
     * @return boolean
     */
    public function dump($destinationFile)
    {
        $command = sprintf('%smysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
            $this->getDumpCommandPath(),
            escapeshellarg($this->user),
            escapeshellarg($this->password),
            escapeshellarg($this->host),
            escapeshellarg($this->port),
            escapeshellarg($this->database),
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
        $command = sprintf('%smysql --user=%s --password=%s --host=%s --port=%s %s < %s',
            $this->getRestoreCommandPath(),
            escapeshellarg($this->user),
            escapeshellarg($this->password),
            escapeshellarg($this->host),
            escapeshellarg($this->port),
            escapeshellarg($this->database),
            escapeshellarg($sourceFile)
        );

        return $this->console->run($command);
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return 'sql';
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->database;
    }

    /**
     * @return string
     */
    protected function getDumpCommandPath()
    {
        return Config::get('db-backup.mysql.dump_command_path');;
    }

    /**
     * @return string
     */
    protected function getRestoreCommandPath()
    {
        return Config::get('db-backup.mysql.restore_command_path');;
    }
}
