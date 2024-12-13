<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test si la page d'inscription est bien accessible.
     *
     * @return void
     */
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Test si les nouveaux utilisateurs peuvent s'enregistrer.
     *
     * @return void
     */
    public function test_new_users_can_register()
    {
        // Envoie les données de l'utilisateur à enregistrer
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Vérifie que l'utilisateur est authentifié
        $this->assertAuthenticated();

        // Vérifie la redirection vers le dashboard
        $response->assertRedirect(route('dashboard', [], false));

        // Vérifie que l'utilisateur a bien été ajouté à la base de données
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com', 
            'first_name' => 'Test',
            'last_name' => 'User',
            'role' => 'member'
        ]);
    }
}
