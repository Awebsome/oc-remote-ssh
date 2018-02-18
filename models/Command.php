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


    public static function run($line, $excId)
    {
        $run = new Self;
        $run->run_id = $excId;
        $run->line = (@is_array($line)) ? json_encode($line) : $line;
        $run->dir = 'input';
        $run->save();
    }

    public static function log($line, $excId)
    {
        if(@is_string($line))
            $blankLine = str_replace(' ','', trim($line));
        else $blankLine = $line;

        if(!empty($blankLine)
        && $blankLine != ''
        && $blankLine != null)
        {
            $log = new Self;
            $log->run_id = $excId;
            $log->line = (@is_array($line)) ? json_encode($line) : $line;
            $log->dir = 'output';

            $log->save();

            return $log;
        }
    }

    public function getResponsesAttribute()
    {
        if($this->dir == 'input')
            return Self::where('dir', 'output')->where('run_id', $this->run_id)->get();
        else return [];
    }
}
