<?php
/**
 * Created by PhpStorm.
 * User: ricardogarci
 * Date: 26/4/17
 * Time: 11:10
 */

namespace App\Http\Controllers\endPoints\v1;

use Illuminate\Http\Request;
use Doctrine\DBAL\Types\Type;
class BaseController 
{

    const RUTE = "App\\";

    public function getClass($path){
        $clase = substr($path, strpos($path, '/', 4)+1);
        if( strpos($clase, '/') != 0 )
            $clase = substr($clase, 0,strpos($clase, '/'));
        return strip_tags(ucfirst($clase));
    }

    public function all(Request $request)
    {
        try {

            //Devuelve la clase segun el prefijo
            $clase = $this->getClass($request->path());
            $clase = self::RUTE.$clase;

            $arrRegistros = $clase::all();

            //En caso de que no haya ninguno devuelve 'Empty'
            if (count($arrRegistros) <= 0)
                $arrRegistros = ['Empty'];

            return response($arrRegistros, 200)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');

        } catch ( QueryException $e ){
            return response($e->getMessage(), 400)
                ->header('Content-Type', 'application/json');
        } catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
                ->header('Content-Type', 'application/json');
        }

    }

    public function findByFilter(Request $request) {
        try {
            //Devuelve la clase segun el prefijo
            $clase = $this->getClass($request->path());
            $clase = self::RUTE . $clase;


            if( !$request->exists('filter')){
               
                return response(null, 400)
                    ->header('Content-Type', 'application/json')
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type');

            }else{
                $query = $clase::query();
                $filters = json_decode($request->input('filter'),true);

                foreach ($filters as $key => $filter){
                    $query->where($key, $filter);
                }
            }
            return response($query->get(), 200)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');

        } catch ( QueryException $e ){
            return response(["message" => $e->getMessage()], 400)
                ->header('Content-Type', 'application/json');
        } catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
                ->header('Content-Type', 'application/json');
        }
    }

    public function find(Request $request, $id)
    {
        try {

            //Devuelve la clase segun el prefijo
            $clase = $this->getClass($request->path());
            $clase = self::RUTE . $clase;

            return response($clase::find($id), 200)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');

        } catch ( QueryException $e ){
            return response(["message" => $e->getMessage()], 400)
            ->header('Content-Type', 'application/json');
        } catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
                ->header('Content-Type', 'application/json');
        }
    }

    public function create(Request $request)
    {
        try {

            //Devuelve la clase segun el prefijo
            $clase = $this->getClass($request->path());
            $clase = self::RUTE.$clase;
            $registro = new $clase;

            //El metodo getFillable() devuelve solo los atributos no devuelve la clave primaria de la tabla
            //por eso si primero recogemos la clave primaria y si es distinto de id significa que primero debemos añadirle la clavePrimaria y luego le añadimos el valor de las demás. (19-12-2017)
            if($registro->getKeyName() != 'id'){
                $registro[ $registro->getKeyName() ] = $request->input($registro->getKeyName());             

                foreach ($registro->getFillable() as $key)
                $registro[$key] = $request->has($key) ? $request->input($key) : null;  

            }else{

                
                foreach ($registro->getFillable() as $key)
                $registro[$key] = $request->has($key) ? $request->input($key) : null;                
            }
          
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

    public function delete(Request $request, $id)
    {
        try{

            //Devuelve la clase segun el prefijo
            $clase = $this->getClass($request->path());
            $clase = self::RUTE.$clase;
            $registro = $clase::find($id);
            $registro->delete();
            return response(['id' => $id], 200)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');

        } catch ( QueryException $e ){
            return response(["message" => $e->getMessage()], 400)
                ->header('Content-Type', 'application/json');

        } catch ( \ReflectionException $e ){
            return response("La clase solicitada no existe", 400)
                ->header('Content-Type', 'application/json');
        }

    }

    public function update(Request $request, $id)
    {
        try{

        //Devuelve la clase segun el prefijo
        $clase = $this->getClass($request->path());
        $clase = self::RUTE.$clase;
        $registro = $clase::find($id);

        $tablas = $registro->getFillable();


        foreach ($tablas as $key){
            if($request->has($key)){
                $registro[$key] =  $request->input($key);
            }
        }

        $registro->save();

        return response(['id' => $registro->id], 200)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');



        } catch ( QueryException $e ){
            return response(["message" => $e->getMessage()], 400)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');

            return response("La clase solicitada no existe", 400)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');
        }catch (Exception $e){
            return response($e, 400)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type');
        }
    }

}