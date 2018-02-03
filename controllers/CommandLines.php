<?php namespace Awebsome\RemoteSsh\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Command Lines Back-end Controller
 */
class CommandLines extends Controller
{

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $ssh_response;

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Awebsome.RemoteSsh', 'remotessh', 'commandlines');
    }
}
