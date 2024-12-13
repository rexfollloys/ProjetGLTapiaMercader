<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Créer un administrateur par défaut
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Utiliser un mot de passe sécurisé
            'role' => 'admin', // Définir le rôle à "admin"
        ]);

        // Créer un chef de projet par défaut
        User::create([
            'first_name' => 'Project',
            'last_name' => 'Manager',
            'email' => 'projectmanager@example.com',
            'password' => Hash::make('password'), 
            'role' => 'project_manager', 
        ]);

        // Créer un membre d'équipe par défaut
        User::create([
            'first_name' => 'Team',
            'last_name' => 'Member',
            'email' => 'teammember@example.com',
            'password' => Hash::make('password'), 
            'role' => 'team_member', 
        ]);
    }
}