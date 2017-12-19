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

		try{
			$archivo = self::RUTE.'archivos';
			
     		$query = $archivo::where('id_vivienda','1')->first();
     		$base64 =  $query->base64;
     		echo $query->tipo_archivo;

     		$base64 = base64_decode($base64);
     		file_put_contents('archivo.pdf',$base64);

     		$headers = array(
              'Content-Type: application/pdf',
            );

            return response()->download('archivo.pdf', 'archivo.pdf', $headers );

		}catch(QueryException  $e){
			return response(["message" => $e->getMessage()],400)
				-header('Content-Type', 'application/json');
		} catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
                ->header('Content-Type', 'application/json');
        }
	}


	//Funcion para descargar las imagenes
	public function ArchivosImagenes(Request $request){
		try{

			$archivo = self::RUTE.'archivos';

			$query = $archivo::where('id_vivienda','1');
			$arrImagenes = [];
			
			
			for($i=0; $i<sizeof( $query->get()); $i++ ){

				if( $query->get()[$i]['tipo_archivo'] == 2){
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


	}


}