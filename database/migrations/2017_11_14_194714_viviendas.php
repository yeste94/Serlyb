<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Viviendas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hastable('viviendas')){
            Schema::create('viviendas', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->bigInteger('UR')->unsigned();
                $table->bigInteger('num_promocion')->unsigned();
                $table->string('Direccion');
                $table->string('Poblacion');
                $table->string('Provincia');
                $table->string('CP');
                $table->string('Tipologia');
                $table->boolean('Inquilino');
                //$table->string('Descripcion_tarea');
                $table->date('fecha_ini');
                $table->date('fecha_fin');
                $table->boolean('terminado');
                $table->boolean('fin');
                $table->string('falta_fin');
                $table->timestamps();
                $table->primary('UR');
                //Poner relación a actuaciones: Actuacion
                //Poner relaciones a las fotos: foto_ini, foto_fin, foto_ing
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
        Schema::dropIfExists('viviendas');
    }
}
