<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Méthode pour afficher tous les utilisateurs
    public function index()
    {
        // Vérification si l'utilisateur a le rôle 'admin'
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }

        // Récupérer tous les utilisateurs
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Méthode pour mettre à jour le rôle d'un utilisateur
    public function updateRole(Request $request, $id)
    {
        // Vérification si l'utilisateur a le rôle 'admin'
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès interdit!');
        }

        // Validation du rôle
        $request->validate([
            'role' => 'required|in:admin,member,project_manager,team_member',
        ]);

        // Trouver l'utilisateur et mettre à jour son rôle
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('dashboard');
    }
}
