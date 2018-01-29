<?php


namespace App\Http\Controllers\endPoints\v1;


use App\Archivos;

use Illuminate\Http\Request;



/**
* 
*/
class ArchivosController extends BaseController
{

	public function crearArchivo(Request $request){
		try {

 			
            $registro = new Archivos;
            

            $base64 = $request->input('base64');
            $tipo_archivo = $request->input('tipo_archivo');
            $id_vivienda = $request->input('id_vivienda');
            $id_trabajador = $request->input('id_trabajador');

            $base64 = str_replace(' ','+',$base64);

            $registro['base64'] = $base64;
            $registro['tipo_archivo'] = $tipo_archivo;
            $registro['id_vivienda'] = $id_vivienda;
            $registro['id_trabajador'] = $id_trabajador;                     
          
            $registro->save();

            return response(['id' => $registro->id], 200)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');

        } catch (QueryException $e) {

            return response(["message" => $e->getMessage()], 400)
                ->header('Content-Type', 'application/json');
        } catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
                ->header('Content-Type', 'application/json');
        }


	}

	
}

