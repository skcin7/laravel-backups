<?php

namespace skcin7\LaravelDbBackup\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dump
 * @package skcin7\LaravelDbBackup\Models
 * @property string file
 * @property string file_name
 * @property string prefix
 * @property boolean encrypted
 * @property Carbon created_at
 */
class Dump extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'database_backups';

    /**
     * @var array
     */
    protected $fillable = [
        'database',
        'file',
        'filename',
        'prefix',
        'encrypted',
        'created_at',
    ];

}