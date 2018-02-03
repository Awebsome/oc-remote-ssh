<?php namespace Awebsome\RemoteSsh\Models;

use Model;

/**
 * SshSettings Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'awebsome_remotessh_settings';
    public $settingsFields = 'fields.yaml';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'awebsome_remotessh_settings';

}
