<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Viviendas extends Model
{
	protected $table = 'viviendas';
	protected $fillable = ['num_promocion','Direccion','Poblacion','Provincia','CP','Tipologia','Inquilino','fecha_ini','fecha_fin','terminado','fin','falta_fin'];
	protected $primaryKey = 'UR';



}