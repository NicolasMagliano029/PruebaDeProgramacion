<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonaTest extends TestCase
{
    public function test_crear()
    {
        $persona = [
            "nombre" => "Martin",
            "apellido" => "Martines",
            "telefono" => 123456789,
        ];
        $response = $this->post("/api/persona", $persona);
        $response -> assertStatus(200);
        $response -> assertJsonStructure(["Mensaje"]);
        $response -> assertJsonFragment(["Mensaje" => "Persona creada correctamente"]);
        $this->assertDatabaseHas("persona", $persona);
    }

    public function test_crearError()
    {
        $persona = [
            "nombre" => "Martin",
            "apellido" => "Martines",
            "telefono" => "123A56789",
        ];
        $response = $this->post("/api/persona", $persona);
        $response -> assertStatus(400);
        $response -> assertJsonStructure(["Error"]);
        $response -> assertJsonFragment(["Error" => "Error al crear Persona"]);
        $this->assertDatabaseMissing("persona", $persona);
    }

    public function test_editar()
    {
        $persona = [
            "nombre" => "Charmander",
            "apellido" => "Rodriguez",
            "telefono" => 987654321,
        ];
        $response = $this->post("/api/persona/1", $persona);
        $response -> assertStatus(200);
        $response -> assertJsonStructure(["Mensaje"]);
        $response -> assertJsonFragment(["Mensaje" => "Persona actualizada correctamente"]);
        $this->assertDatabaseHas("persona", $persona);
    }

    public function test_editarError()
    {
        $persona = [
            "nombre" => "Charmander",
            "apellido" => "Rodriguez",
            "telefono" => "987a5a321",
        ];
        $response = $this->post("/api/persona/1", $persona);
        $response -> assertStatus(400);
        $response -> assertJsonStructure(["Error"]);
        $response -> assertJsonFragment(["Error" => "Error al actualizar Persona"]);
        $this->assertDatabaseMissing("persona", $persona);
    }

    public function test_listar(){
        $response = $this->get("/api/personas");
        $response -> assertStatus(200);
        $response -> assertJsonStructure(["Personas" => ["*" => ["id", "nombre", "apellido", "telefono", "created_at", "updated_at", "deleted_at"]]]);
    }

    public function test_buscar(){
        $response = $this->get("/api/persona/1");
        $response -> assertStatus(200);
        $response -> assertJsonStructure(["Persona" => ["id", "nombre", "apellido", "telefono", "created_at", "updated_at", "deleted_at"]]);
    }

    public function test_buscarError(){
        $response = $this->get("/api/persona/999");
        $response -> assertStatus(404);
        $response -> assertJsonStructure(["Error"]);
        $response -> assertJsonFragment(["Error" => "Persona no encontrada"]);
    }

    public function test_eliminar(){
        $response = $this->get("/api/persona/1/eliminar");
        $response -> assertStatus(200);
        $response -> assertJsonStructure(["Mensaje"]);
        $response -> assertJsonFragment(["Mensaje" => "Persona eliminada correctamente"]);
        $this->assertSoftDeleted("persona", ["id" => 1]);
    }

    public function test_eliminarError(){
        $response = $this->get("/api/persona/999/eliminar");
        $response -> assertStatus(400);
        $response -> assertJsonStructure(["Error"]);
        $response -> assertJsonFragment(["Error" => "Error al eliminar Persona"]);
    }
}
