<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;

class PersonaController extends Controller
{
    public function crear(Request $request){
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

    public function lista(Request $request){
        try {
            $personas = Persona::all();
            return $personas;
        } catch (\Exception $err){
            return response()->status(400)->json(["error mesage" => "No encontrado"]);
        }
    }

    public function mostrar(Request $request, $id){
        try {
            $persona = Persona::findOrFail($id);
            return $persona;
        } catch (\Exception $err){
            return response()->status(400)->json(["error mesage" => "No encontrado"]);
        }
    }

    public function editar(Request $request, $id){
        try {
            $persona = Persona::findOrFail($id);
            if ($request->has("nombre")) $persona-> nombre = $request->post("nombre");
            if ($request->has("apellido")) $persona->apellido = $request->post("apellido");
            if ($request->has("telefono")) $persona->telefono = $request->post("telefono");
            $persona->save();
            return $persona;
        } catch (\Exception $err){
            return response()->status(400)->json(["error mesage" => "No actualizado"]);
        }
    }

    public function eliminar(Request $request, $id){
        try {
            $persona = Persona::findOrFail($id);
            $persona->delete();
            return response()->json(["message" => "Eliminado correctamente"]);
        } catch (\Exception $err){
            return response()->status(400)->json(["error mesage" => "No eliminado"]);
        }
    }
}

