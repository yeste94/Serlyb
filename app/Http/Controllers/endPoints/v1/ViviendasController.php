<?php 

namespace App\Http\Controllers\endPoints\v1;

use App\Viviendas;
use App\Archivos;

/**
* 
*/
class ViviendasController extends BaseController
{

    const RUTE = "App\\";



    //Funcion para descargar el archivo PDF
	public function ArchivoPDF(Request $request){
		//Si no han puesto el id en la petición manda un erro 400
		if($request->has('id') ){

			try{

				//Obtenemos el id de la petición
				$id = $request->input('id');

				//Obtenemos de la base de datos el archivo pdf en base64
	     		$query = Archivos::where('id_vivienda', $id)
	     						->where('tipo_archivo',0)
	     						->first();

	     		$base64 =  $query->base64;
	     		//decodificamos el archivo par obtener el pdf y lo guardamos en el servidor
	     		$base64 = base64_decode($base64);
	     		file_put_contents('archivo.pdf',$base64);

     			$headers = array(
	              	'Content-Type: application/pdf',
            	);
     			//Devolvemos el archivo para descargarlo.
            	return response()->download('archivo.pdf', 'archivo.pdf', $headers );

			}catch(QueryException  $e){
				return response(["message" => $e->getMessage()],400)
					-header('Content-Type', 'application/json');
			} catch ( \ReflectionException $e ){
            	return response("La clase solicitada no existe", 400)
                	->header('Content-Type', 'application/json');
        	}

		}else{
			  return response(null, 400)
                ->header('Content-Type', 'application/json');
		}

		
	}


	//Funcion para descargar las imagenes
	public function ArchivosImagenes(Request $request){
		//Si no han puesto el id en la petición manda un error 400
		if($request->has('id') && $request->has('tipo_archivo') ){
			try{

				//Obtenemos el id de la petición y el tipo de archivo
				$id = $request->input('id');
				$tipo_archivo = $request->input('tipo_archivo');

				//Obtenemos todas las imagenes relacionados con la vivienda
				$query = Archivos::where('id_vivienda', $id);
				$arrImagenes = [];
				
				//Vamos metiendo en el array todos los archivos que queremos obtener
				//0 - Archivo PDF
				//1 - Imagen ANTES
				//2 - Imagen DESPUES
				for($i=0; $i<sizeof( $query->get()); $i++ ){

					if( $query->get()[$i]['tipo_archivo'] == $tipo_archivo){
						array_push( $arrImagenes, $query->get()[$i] );
					}
				}

	   			//Creamos la clase zip y comprimimos las fotos
				$zip = new ZipArchive;
				$filename = 'fotos.zip';	


				if($zip->open($filename, ZIPARCHIVE::OVERWRITE ) === true){

					for( $i=0; $i<sizeof($arrImagenes); $i++ ){					

						$img = base64_decode($arrImagenes[$i]->base64);
						file_put_contents('archivo'.$i.'.jpg', $img);

						$zip->addFile('archivo'.$i.'.jpg');
					}
					$zip->close();
				}
	     		$headers = array(
	              'Content-Type: application/zip',
	            );

				return response()->download('fotos.zip', 'fotos.zip', $headers);

			}catch(QueryException  $e){
				return response(["message" => $e->getMessage()],400)
					-header('Content-Type', 'application/json');
			} catch ( \ReflectionException $e ){
	            return response("La clase solicitada no existe", 400)
	                ->header('Content-Type', 'application/json');
	        }

		}else{
			return response(null, 400)
					-header('Content-Type', 'application/json');
		}
	}


}