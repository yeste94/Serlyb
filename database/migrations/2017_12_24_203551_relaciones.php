<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Relaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Relacion viviendas y fotos
        if(Schema::hastable('viviendas') && Schema::hastable('fotos')){
            Schema::table('fotos', function (Blueprint $table){
               $table->foreign('id_vivienda')->references('UR')->on('viviendas');
            });
        }
        //Relacion fotos a trabajador
        if(Schema::hastable('fotos') && Schema::hastable('trabajador')){
            Schema::table('fotos', function (Blueprint $table){
               $table->foreign('id_trabajador')->references('id')->on('trabajador');
            });
        }
        
        //Relacion trab_vivienda_dia a trabajador
        if(Schema::hastable('trab_vivienda_dia') && Schema::hastable('trabajador')){
            Schema::table('trab_vivienda_dia', function (Blueprint $table){
               $table->foreign('id_trabajador')->references('id')->on('trabajador');
            });
        }

        //Relacion viviendas y trab_vivienda_dia
        if(Schema::hastable('viviendas') && Schema::hastable('trab_vivienda_dia')){
            Schema::table('trab_vivienda_dia', function (Blueprint $table){
               $table->foreign('id_vivienda')->references('UR')->on('viviendas');
            });
        }

        //Relacion usuario a trabajador
        if(Schema::hastable('trabajador') && Schema::hastable('usuario')){
            Schema::table('usuario', function (Blueprint $table){
               $table->foreign('id_trabajador')->references('id')->on('trabajador');
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
