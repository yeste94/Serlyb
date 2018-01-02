<?php 

namespace App\Http\Controllers\endPoints\v1;

use App\TrabViviendaDia;
use App\Trabajador;

use Illuminate\Http\Request;
use Doctrine\DBAL\Types\Type;

/**
* 
*/
class TrabVivendaDiaController extends BaseController
{
	
	//Funcion que devuelve la fecha insertadas de la vivienda
	public function getDateVivendaDia(Request $request){
		try{

			$clase = TrabViviendaDia::where('id_vivienda',1)
				->distinct()
				->get(['id_vivienda','DATE']);
		
			return response($clase, 200)
				->header('Content-Type', 'application/json');

		}catch(QueryException  $e){
			return response(["message" => $e->getMessage()],400)
				->header('Content-Type', 'application/json');
		} catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
               	->header('Content-Type', 'application/json');
        }
		
	}


	//funcion que devuelve los trabajadores que han trabajado en la vivienda en tal dia
	public function getTrabajadores(Request $request){
		try{
			$arrTraba = [];

			//Obtenemos los id de los trabajadores que han estado ese dia en la vivienda
			$idTrabajadores = TrabViviendaDia::where('id_vivienda', 1)
							->Where('DATE', '2017-12-28')
							->get(['id_trabajador']);
				
			//Con este bucle obtenemos los trabajadores y los metemos un array.
			for($i=0; $i<sizeof($idTrabajadores); $i++  ) {
				array_push( $arrTraba, Trabajador::where('id', $idTrabajadores[$i]['id_trabajador'])
										->get() );

			}


			return response($arrTraba,200)
				->header('Content-Type', 'application/json');

		}catch(QueryException  $e){
			return response(["message" => $e->getMessage()],400)
				->header('Content-Type', 'application/json');
		} catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
               	->header('Content-Type', 'application/json');
        }


	}



}


