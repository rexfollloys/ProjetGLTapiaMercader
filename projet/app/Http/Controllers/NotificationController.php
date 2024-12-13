<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function destroy($id)
    {
        // Récupérer la notification à supprimer
        $notification = Notification::findOrFail($id);

        // Supprimer la notification
        $notification->delete();

        // Rediriger vers le tableau de bord avec un message de succès
        return redirect()->route('dashboard')->with('success', 'Notification supprimée avec succès');
    }
}
