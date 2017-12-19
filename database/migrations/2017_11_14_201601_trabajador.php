<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Trabajador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hastable('trabajador')){
            Schema::create('trabajador',function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('nombre');
                $table->string('apellido1');
                $table->string('apellido2');
                $table->string('DNI');
                $table->string('telefono');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
