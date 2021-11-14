<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_home()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function test_get_recipes()
    {
        $response = $this->get('/recipes');
        $response->assertStatus(200);
    }
    public function test_get_shoppinglist()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)
            ->get('/shoppinglist');
        $response->assertStatus(200);
    }

}
