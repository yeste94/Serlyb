<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// $router->routeMiddleware([
//     'Cors' => 'App\Http\Middleware\Cors',
// ]);


$router->group(['prefix' => 'api' /*, 'middleware' => 'Cors' */], function ($router)
{
    //-----VERSION 1.0------
    $router->group(['prefix' => 'v1/', 'namespace' => 'endPoints\v1'], function ($router){

    	// ------ARCHIVOS--------
		$router->group(['prefix' => 'archivos'], function($router){
    		$router->get('/','ArchivosController@all');
    		$router->post('create','ArchivosController@crearArchivo');
            $router->post('createDrive','ArchivosController@insertDrive');


    		$router->delete('{id}','ArchivosController@delete');
    		$router->put('{id}','ArchivosController@update');
            $router->get('{id}','ArchivosController@find');
            $router->post('findfilter','ArchivosController@findByFilter');
    	});    	

		// ------TRABAJADOR-------
		$router->group(['prefix' => 'trabajador'], function($router){
    		$router->get('/','TrabajadorController@all');
    		$router->post('create','TrabajadorController@create');
    		$router->delete('{id}','TrabajadorController@delete');
    		$router->put('{id}','TrabajadorController@update');
            $router->get('{id}','TrabajadorController@find');
            $router->post('findfilter','TrabajadorController@findByFilter');
    	});

		// -----VIVIENDAS------
		$router->group(['prefix' => 'viviendas'], function($router){
    		$router->get('/','ViviendasController@all');
            $router->get('viviendaFin', 'ViviendasController@getViviendaNoFin');
    		$router->post('create','ViviendasController@create');
    		$router->delete('{id}','ViviendasController@delete');
    		$router->put('{id}','ViviendasController@update');
            $router->get('{id}','ViviendasController@find');
            $router->post('findfilter','ViviendasController@findByFilter');
            
            $router->get('pdf/{img}','ViviendasController@ArchivoPDF');
            $router->get('img/{img}','ViviendasController@ArchivosImagenes');

    	});

        // -----USUARIO------
        $router->group(['prefix' => 'usuario'], function($router){
            $router->get('/','UsuarioController@all');
            $router->post('create','UsuarioController@create');
            $router->delete('{id}','UsuarioController@delete');
            $router->put('{id}','UsuarioController@update');
            $router->get('{id}','UsuarioController@find');
            $router->post('findfilter','UsuarioController@findByFilter');

            $router->post('login','UsuarioController@login');
        });

        //-----TRABAJADOR USUARIO DIA -------------
        $router->group(['prefix'=> 'trabviviendadia'], function($router){
            $router->get('/','TrabVivendaDiaController@all');
            $router->get('date','TrabVivendaDiaController@getDateVivendaDia');
            $router->get('idTrabajador','TrabVivendaDiaController@getTrabajadores');
            
            $router->post('create','TrabVivendaDiaController@create');
            $router->post('createtrabajadorvivienda', 'TrabVivendaDiaController@crearTrabajadorVivienda');            

            $router->delete('{id}','TrabVivendaDiaController@delete');
            $router->put('{id}','TrabVivendaDiaController@update');
            $router->get('{id}','TrabVivendaDiaController@find');
            $router->post('findfilter','TrabVivendaDiaController@findByFilter');

        });

    });
});