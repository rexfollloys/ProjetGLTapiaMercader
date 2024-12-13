<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Vérifiez si l'utilisateur est un administrateur
        if (Auth::user()->role === 'admin') {
            // Si admin, récupérer tous les projets
            $projects = Project::all();
        } else {
            // Récupérer les projets auxquels l'utilisateur est assigné
            $projects = Auth::user()->projects;
        }

        // Retourner la vue avec les projets
        return view('dashboard', compact('projects'));
    }
    public function showDashboard()
    {
        $notifications = auth()->user()->notifications;  // Récupérer les notifications de l'utilisateur
    
        return view('dashboard', compact('notifications'));  // Passer les notifications à la vue
    }
}
