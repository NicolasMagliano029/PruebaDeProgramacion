<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;

class PersonaController extends Controller
{
    public function crear(request $request){
       try {
            $persona = new Persona();
            $persona->nombre = $request->post("nombre");
            $persona->apellido = $request->post("apellido");
            $persona->telefono = $request->post("telefono");
            $persona->save();
            return $persona;
        } catch (\Exception $err){
            return response()->status(400)->json(["error mesage" => "No creado"]); 
        }
    }

}

