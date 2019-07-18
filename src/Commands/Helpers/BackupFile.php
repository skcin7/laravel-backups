<?php

namespace skcin7\LaravelDbBackup\Commands\Helpers;

use Carbon\Carbon;

/**
 * Class BackupFile
 * @package skcin7\LaravelDbBackup\Commands\Helpers
 */
class BackupFile
{
    /**
     * @var string
     */
    private $fileName;
    private $filePath;

    /**
     * @param mixed $filenameArg
     * @param skcin7\LaravelDbBackup\Databases\DatabaseContract $database
     * @param string $dumpPath
     * @return skcin7\LaravelDbBackup\Commands\Helpers\BackupFile
     */
    public function __construct($filenameArg, $database, $dumpPath)
    {
        if($filenameArg) {
            $this->buildWithArguments($filenameArg);
        }
        else {
            $this->build($dumpPath, $database);
        }
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->filePath;
    }

    /**
     * @param string $dumpPath
     * @param string $database
     * @return void
     */
    private function build($dumpPath, $database)
    {
        $this->fileName = $database->getDatabaseName() . '-' . Carbon::now()->format('Y-m-d-H-i-s') . '.' . $database->getFileExtension();
        $this->filePath = rtrim($dumpPath, '/') . '/' . $this->fileName;
    }

    /**
     * @param string $filename
     * @return void
     */
    private function buildWithArguments($filename)
    {
        $this->filePath = substr($filename, 0, 1) !== '/' ? getcwd() . '/' : '';
        $this->filePath .= $filename;

        $this->fileName = basename($this->filePath);
    }
}
