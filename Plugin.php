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
        /**
         * Register "/config/remote.php" for SSH
        */
        /*Config::set('remote.connections.remotessh.host',       CFG::get('ssh.host'));
        Config::set('remote.connections.remotessh.username',   CFG::get('ssh.username'));
        Config::set('remote.connections.remotessh.password',   CFG::get('ssh.password'));
        Config::set('remote.connections.remotessh.key',        CFG::get('ssh.key'));
        Config::set('remote.connections.remotessh.keyphrase',  CFG::get('ssh.keyphrase'));
        Config::set('remote.connections.remotessh.root',       'apps');*/

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
            'remotessh'  => [
                'label'       => 'Remote SSH',
                'description' => 'Settings of Remote SSH',
                'category'    => 'Remote SSH',
                'icon'        => 'icon-terminal',
                'class'       => 'Awebsome\RemoteSsh\Models\Settings',
                'order'       => 100,
                'permissions' => [ 'awebsome.remotessh.settings' ],
                'keywords'    => 'Server Remote Ssh'
            ],
        ];
    }
}
