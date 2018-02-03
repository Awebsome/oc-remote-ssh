<?php namespace Awebsome\Remotessh\Models;

use Model;

/**
 * Command Model
 */
class Command extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'awebsome_remotessh_commands';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public static function log($runId, $line, $dir)
    {
        if(@is_string($line))
            $blankLine = str_replace(' ','', trim($line));
        else $blankLine = $line;
        
        if(!empty($blankLine)
        && $blankLine != ''
        && $blankLine != null)
        {
            $log = new Self;
            $log->run_id = $runId;
            $log->line = (@is_array($line)) ? json_encode($line) : $line;
            $log->dir = $dir;

            $log->save();

            return $log;
        }
    }
}
