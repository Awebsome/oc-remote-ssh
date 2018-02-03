<?php namespace Awebsome\RemoteSsh\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('awebsome_remotessh_commands', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('run_id');
            $table->enum('dir', ['input', 'output'])->nullable();
            $table->longText('line')->nullable();
            $table->timestamps();
        });

        Schema::create('awebsome_remotessh_commandlines', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->string('bind')->nullable();
            $table->text('command');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('awebsome_remotessh_commands');
        Schema::dropIfExists('awebsome_remotessh_commandlines');
    }
}
