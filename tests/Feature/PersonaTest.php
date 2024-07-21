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
}
