<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Usuario extends Model
{
	protected $table = 'usuario';
	protected $fillable = ['pass','id_trabajador'];
	protected $primaryKey = 'nick';



}