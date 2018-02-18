<?php namespace Awebsome\Remotessh\Controllers;

use Backend;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;

use Awebsome\Remotessh\Models\Command;

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

    public function show($recordId)
    {
        $command = Command::find($recordId);

        if($command)
        {
            if($command->dir == 'output')
                $command = Command::where('dir', 'input')->where('run_id', $command->run_id)->first();

            return Redirect::to(Backend::url('awebsome/remotessh/commands/preview/'.$command->id));

        } else return Redirect::to(Backend::url('awebsome/remotessh/commands'));
    }
}
