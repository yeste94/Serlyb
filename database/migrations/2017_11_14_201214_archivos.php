<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class archivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hastable('archivos')){
            Schema::create('archivos', function(Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->longText('base64');
                $table->integer('tipo_archivo')->unsigned();
                $table->bigInteger('id_vivienda')->unsigned();
                $table->integer('id_trabajador')->unsigned();
                $table->timestamps();

                //Relacion del trabajador
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
        Schema::dropIfExists('fotos');
    }
}
