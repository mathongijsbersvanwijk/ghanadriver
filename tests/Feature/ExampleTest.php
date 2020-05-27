<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = new User(['id' => 1, 'name' => 'Mathon']);
        echo $user->name;
        
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
