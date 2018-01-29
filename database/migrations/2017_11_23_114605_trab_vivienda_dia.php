<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrabViviendaDia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hastable('trab_vivienda_dia')){
            Schema::create('trab_vivienda_dia', function(Blueprint $table){
                $table->engine = 'InnoDb';
                $table->increments('id')->unsigned();
                $table->bigInteger('id_vivienda')->unsigned();
                $table->integer('id_trabajador')->unsigned();
                $table->date('date');
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
