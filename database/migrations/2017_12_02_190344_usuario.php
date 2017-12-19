<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hastable('usuario')){
            Schema::create('usuario', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->string('nick');
                $table->string('pass');
                $table->integer('id_trabajador')->unsigned();
                $table->primary('nick');
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
        //Schema::dropIfExists('viviendas');
    }
}
