<?php namespace Awebsome\Ssh;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        // Register ServiceProviders
        \App::register('Collective\Remote\RemoteServiceProvider');

        // Register aliases
        $alias = \Illuminate\Foundation\AliasLoader::getInstance();
        $alias->alias('SSH', 'Collective\Remote\RemoteFacade');
    }
}
