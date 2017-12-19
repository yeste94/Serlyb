<?php 


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Trabajador extends Model
{
	protected $table = 'trabajador';
	protected $fillable = ['nombre','apellido1','apellido2','DNI','telefono'];
	protected $primaryKey = 'id';


	

}
