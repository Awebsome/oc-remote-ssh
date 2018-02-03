<?php namespace Awebsome\Remotessh\Controllers;


use SSH2;
use Log;
use Event;

use BackendMenu;
use Backend\Classes\Controller;

use Awebsome\RemoteSsh\Models\Command;

/**
 * Commands Back-end Controller
 */
class Commands extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Awebsome.RemoteSsh', 'remotessh', 'commands');
    }

    public function test()
    {
        $runId = str_random(6). ' '.time();

        $commands = [
            'cd apps/development',
            'php artisan october:up',
            'php artisan cache:clear',
        ];


        Command::log($runId, $commands, 'input');

        SSH2::into('remotessh')->run($commands, function($line) use ($runId)
        {
            Command::log($runId,  $line, 'output');
        });

        return $this->ssh_response;
    }
}
