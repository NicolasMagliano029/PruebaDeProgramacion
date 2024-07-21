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
            return response()->json(["Mensaje" => "Persona creada correctamente"]);
        } catch (\Exception $err){
            return response()->json(["Error" => "Error al crear Persona"], 400); 
        }
    }

    public function lista(Request $request){
        try {
            $personas = Persona::all();
            return response()->json(["Personas"=>$personas]);
        } catch (\Exception $err){
            return response()->json(["Error" => "Error al listar Personas"], 500);
        }
    }

    public function mostrar(Request $request, $id){
        try {
            $persona = Persona::findOrFail($id);
            return response()->json(["Persona"=>$persona]);
        } catch (\Exception $err){
            return response()->json(["Error" => "Persona no encontrada"], 404);
        }
    }

    public function editar(Request $request, $id){
        try {
            $persona = Persona::findOrFail($id);
            if ($request->has("nombre")) $persona-> nombre = $request->post("nombre");
            if ($request->has("apellido")) $persona->apellido = $request->post("apellido");
            if ($request->has("telefono")) $persona->telefono = $request->post("telefono");
            $persona->save();
            return response()->json(["Mensaje" => "Persona actualizada correctamente"]);
        } catch (\Exception $err){
            return response()->json(["Error" => "Error al actualizar Persona"], 400);
        }
    }

    public function eliminar(Request $request, $id){
        try {
            $persona = Persona::findOrFail($id);
            $persona->delete();
            return response()->json(["Mensaje" => "Persona eliminada correctamente"]);
        } catch (\Exception $err){
            return response()->json(["Error" => "Error al eliminar Persona"], 400);
        }
    }
}

