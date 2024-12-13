<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Identifiant unique pour chaque commentaire
            $table->foreignId('task_id')->constrained()->onDelete('cascade'); // Lien avec la tâche (onDelete cascade pour supprimer les commentaires si la tâche est supprimée)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Lien avec l'utilisateur (lors de la suppression de l'utilisateur, les commentaires sont supprimés)
            $table->text('content'); // Contenu du commentaire
            $table->timestamps(); // Pour garder une trace de la création et de la mise à jour des commentaires
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
