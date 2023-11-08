<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    
    /**
     * A basic unit test example.
     */
    public function test_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_duplication()
    {
        $user1 = User::make([
            'name'=> 'Tedo',
            'email' => 'tedo@abv.bg'
        ]);

        $user2 = User::make([
            'name'=> 'Ang',
            'email' => 'ang@abv.bg'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_it_stores_new_users()
    {
        $response = $this->post('/register', [
            'name' => 'Tedo',
            'email' => 'tedo@abv.bg',
            'password' => 'parola123',
            'password_confirmation' => 'parola123'
        ]);

        $response->assertRedirect('/home');

        $user = User::where('name', 'Tedo')->first();
        $user->delete();
    }

    public function test_database_has_this()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'test'
        ]);
    }

    public function test_database_has_not()
    {
        $this->assertDatabaseMissing('users', [
            'name' => 'Tedo'
        ]);
    }

    public function test_database_count()
    {
        $this->assertDatabaseCount('users', 1);
    }
}
