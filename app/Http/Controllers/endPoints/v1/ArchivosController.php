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
            
            $base64 = explode(',',$request->input('base64'));
            $tipo_archivo = $request->input('tipo_archivo');
            $id_vivienda = $request->input('id_vivienda');
            $id_trabajador = $request->input('id_trabajador');

            $base64 = str_replace(' ','+',$base64);



            for($i=0;$i<sizeof( $base64); $i++){

                $existe=true;
                $cont=0;
                //Bucle que va guardando el archivo, va guardando los archivos de las viviendas en funcion de archivo"id_vivienda"_numeroarchivo así nunca se repetirá el nombre del archivo
                while($existe){
                    if(file_exists('archivo'.$id_vivienda.'_'.$cont.'.jpg') == 1){
                        $cont++;                
                    }else{
                        file_put_contents('archivo'.$id_vivienda.'_'.$cont.'.jpg', $base64[$i]);
                        $existe=false;
                    }
                }




                $registro = new Archivos;
            
                $registro['base64'] = 'archivo'.$id_vivienda.'_'.$cont.'.jpg';
                $registro['tipo_archivo'] = $tipo_archivo;
                $registro['id_vivienda'] = $id_vivienda;
                $registro['id_trabajador'] = $id_trabajador;                     
          
                $registro->save();
    
            }
            
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

