<?php namespace Awebsome\RemoteSsh;


use App;
use Config;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

use Awebsome\RemoteSsh\Models\Settings as CFG;

class Plugin extends PluginBase
{
    public function boot()
    {
        // Register ServiceProviders
        App::register('Collective\Remote\RemoteServiceProvider');

        // Register aliases
        $alias = AliasLoader::getInstance();
        $alias->alias('SSH2', 'Collective\Remote\RemoteFacade');
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            //Connection Settings
            /*'remotessh'  => [
                'label'       => 'Remote SSH',
                'description' => 'Settings of Remote SSH',
                'category'    => 'Remote SSH',
                'icon'        => 'icon-terminal',
                'class'       => 'Awebsome\RemoteSsh\Models\Settings',
                'order'       => 100,
                'permissions' => [ 'awebsome.remotessh.settings' ],
                'keywords'    => 'Server Remote Ssh'
            ],*/
        ];
    }
}
