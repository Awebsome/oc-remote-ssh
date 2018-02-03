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
        Config::set('remote.connections.RemoteSSH.key',        CFG::get('ssh.key'));
        Config::set('remote.connections.RemoteSSH.keyphrase',  CFG::get('ssh.keyphrase'));
        Config::set('remote.connections.RemoteSSH.root',       'apps');

        $self->connection = $params;

        return $self;
    }

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }


    public function run($commands)
    {
        $runId = str_random(6). ' '.time();


        $commands = $this->getCommands($commands);

        Command::log($runId, $commands, 'input');

        SSH2::into('RemoteSSH')->run($commands, function($line) use ($runId)
        {
            Command::log($runId,  $line, 'output');
        });
    }


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

    public function getCommandLine($command)
    {
        $commandLine = CommandLine::where('bind', $command)->first();

        if($commandLine)
            return $this->setCommandData($commandLine->command);
        else return $command;
    }

    public function setCommandData($command)
    {
        $data = $this->data;

        if(count($data) >= 1)
        {
            foreach ($data as $key => $value) {
                $command = str_replace('{'.$key.'}', $value, $command);
            }
        }

        return $command;
    }
}
