<?php 

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Trabviviendadia extends Model
{
	protected $table = 'trab_vivienda_dia';	
	protected $fillable = ['id_vivienda','id_trabajador','date'];
	protected $primaryKey = 'id';




}