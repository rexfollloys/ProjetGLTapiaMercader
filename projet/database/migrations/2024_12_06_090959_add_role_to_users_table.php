<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'role')) {
            // Ajouter une nouvelle colonne 'role' à la table 'users'
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['member', 'admin', 'project_manager'])->default('member');
            });
        }
    }

    public function down()
    {
        // Si la migration est annulée, supprimer la colonne 'role'
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
