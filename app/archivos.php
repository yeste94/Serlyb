<?php 

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Archivos extends Model
{
	protected $table = 'archivos';	
	protected $fillable = ['base64','tipo_archivo','id_vivienda','id_trabajador'];
	protected $primaryKey = 'id';




}