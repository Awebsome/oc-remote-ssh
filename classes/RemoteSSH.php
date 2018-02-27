<?php namespace Awebsome\RemoteSsh\Classes;

use SSH2;
use Config;
use Awebsome\RemoteSsh\Models\CommandLine;
use Awebsome\RemoteSsh\Models\Command;
use Awebsome\RemoteSsh\Models\Settings as CFG;

/**
 * Remote SSH library.
 */
class RemoteSSH
{
    public $connection;
    public $data;

    public static function auth($params = null)
    {
        $self = new RemoteSSH;

        /**
         * Register "/config/remote.php" for SSH
        */
        Config::set('remote.connections.RemoteSSH.host',       (@$params['host']) ? $params['host'] : 'localhost');
        Config::set('remote.connections.RemoteSSH.username',   $params['username']);
        Config::set('remote.connections.RemoteSSH.password',   $params['password']);
        Config::set('remote.connections.RemoteSSH.key',        @$params['key']);
        Config::set('remote.connections.RemoteSSH.keyphrase',  @$params['keyphrase']);
        Config::set('remote.connections.RemoteSSH.root',       'apps');

        $self->connection = $params;

        return $self;
    }

    /**
    *   set Data
    * ===================================================
    * @param array data for the command line.
    * use to replace the data {varname}
    */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }


    /**
     * run commands
     */
    public function run($commands)
    {
        //set execution id (run_id)
        $excId = str_random(6).time();

        $commands = $this->getCommands($commands);

        Command::run($commands, $excId);

        SSH2::into('RemoteSSH')->run($commands, function($line) use ($excId)
        {
            Command::log($line, $excId);
        });
    }

    /**
     * get Commands
     * =====================================
     * get commands to run.
     */
    public function getCommands($commands)
    {
        $cmds = [];

        if(count($commands) >= 1){
            foreach ($commands as $key => $command) {
                $cmds[] = $this->getCommandLine($command);
            }
        }

        return $cmds;
    }

    /**
     * get Command Line
     * ===================================================
     * get command line by "bind command"
     */
    public function getCommandLine($command)
    {
        $cmdLine = CommandLine::where('bind', $command)->first();

        if($cmdLine)
            return $cmdLine->getCommandWith($this->data);
        else return $command;
    }
}
