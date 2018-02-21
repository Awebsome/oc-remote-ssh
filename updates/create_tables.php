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
            $table->string('run_id')->nullable();

            $table->longText('line')->nullable();
            $table->enum('dir', ['input', 'output'])->nullable();
            $table->timestamps();
        });

        Schema::create('awebsome_remotessh_commandlines', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->index();
            $table->string('bind')->nullable();
            $table->longText('command');

            $table->boolean('deletable')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('awebsome_remotessh_commands');
        Schema::dropIfExists('awebsome_remotessh_commandlines');
    }
}
