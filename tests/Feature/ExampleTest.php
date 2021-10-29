<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{

      /** @test */


    public function get_recipes()
    {
        $response = $this->get('/recipes');

        $response->assertStatus(200);
    }
    public function get_home()
{
    $response = $this->get('/');

    $response->assertStatus(200);
}
}
