<?php

namespace skcin7\LaravelDbBackup;

use skcin7\LaravelDbBackup\Console;
use skcin7\LaravelDbBackup\Databases\MySQLDatabase;
use skcin7\LaravelDbBackup\Databases\SqliteDatabase;
use skcin7\LaravelDbBackup\Databases\PostgresDatabase;

/**
 * Class DatabaseBuilder
 * @package skcin7\LaravelDbBackup
 */
class DatabaseBuilder
{
    /**
     * @var array
     */
    protected $database;

    /**
     * @var skcin7\LaravelDbBackup\Console
     */
    protected $console;

    /**
     * DatabaseBuilder constructor.
     */
    public function __construct()
    {
        $this->console = new Console();
    }

    /**
     * @param array $realConfig
     * @return array
     * @throws \Exception
     */
    public function getDatabase(array $realConfig)
    {
        switch ($realConfig['driver']) {
            case 'mysql':
                $this->buildMySQL($realConfig);
                break;
            case 'sqlite':
                $this->buildSqlite($realConfig);
                break;
            case 'pgsql':
                $this->buildPostgres($realConfig);
                break;
            default:
                throw new \Exception('Database driver not supported yet');
                break;
        }

        return $this->database;
    }

    /**
     * @param array $config
     * @return void
     */
    protected function buildMySQL(array $config)
    {
        $port = isset($config['port']) ? $config['port'] : 3306;

        $this->database = new MySQLDatabase(
            $this->console,
            $config['database'],
            $config['username'],
            $config['password'],
            $config['host'],
            $port
        );
    }

    /**
     * @param array $config
     * @return void
     */
    protected function buildSqlite(array $config)
    {
        $this->database = new SqliteDatabase(
            $this->console,
            $config['database']
        );
    }

    /**
     * @param array $config
     * @return void
     */
    protected function buildPostgres(array $config)
    {
        $this->database = new PostgresDatabase(
            $this->console,
            $config['database'],
            $config['username'],
            $config['password'],
            $config['host']
        );
    }
}