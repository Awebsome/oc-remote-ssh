<?php namespace Awebsome\RemoteSsh\Models;

use Model;
use ValidationException;

/**
 * CommandLine Model
 */
class CommandLine extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'awebsome_remotessh_commandlines';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules
     */
    protected $rules = [
        'name'=> 'required|unique:awebsome_remotessh_commandlines',
        'bind'=> 'required|unique:awebsome_remotessh_commandlines',
        'command'=> 'required',
    ];

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

    public function beforeDelete()
    {
        try{

            if(!$this->deletable)
                throw new ValidationException(['error_mesage' => 'This command can not be deleted, it is probably used by another plugin']);

        }catch(\ValidationException $e)
        {
            throw new ValidationException(['error_mesage' => $e->getMessage()]);
        }
    }

    /**
     * set Command Data
     * ===================================================
     * set command data in CommandLine
     */
    public function getCommandWith($data)
    {
        $command = $this->command;

        if(count($data) >= 1)
        {
            foreach ($data as $key => $value) {
                $command = str_replace('{'.$key.'}', $value, $command);
            }
        }

        return $command;
    }
}
