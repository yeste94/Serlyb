<?php

namespace App\Http\Controllers\endPoints\v1;

use App\Usuario;
use Illuminate\Http\Request;
use Doctrine\DBAL\Types\Type;

class UsuarioController extends BaseController
{
	const RUTE = "App\\";


	public function login(Request $request){	


		if($request->has('username') && $request->has('password') ){

			$user = new Usuario();

			$user = Usuario::where('nick', $request->input('username'))
					->where('pass',$request->input('password'))
					->first();

			if($user){
				return response('Login', 200)
	                ->header('Content-Type', 'application/json')
	                ->header('Access-Control-Allow-Origin', '*')
	                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
	                ->header('Access-Control-Allow-Headers', 'Content-Type');

			}else{
				return response('Error', 401)
	                ->header('Content-Type', 'application/json')
	                ->header('Access-Control-Allow-Origin', '*')
	                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
	                ->header('Access-Control-Allow-Headers', 'Content-Type');
			}

		}else{
			return response('Error', 401)
	                ->header('Content-Type', 'application/json')
	                ->header('Access-Control-Allow-Origin', '*')
	                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
	                ->header('Access-Control-Allow-Headers', 'Content-Type');
		}
	}
}