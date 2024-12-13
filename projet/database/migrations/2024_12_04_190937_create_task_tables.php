<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_tasks_table.php

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            //lorsque projet supprimé, toutes les tâches liées à ce projet seront également supprimées 
            //(grâce à la contrainte de suppression en cascade).
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Lien avec le projet
            $table->string('title'); // Titre de la tâche
            $table->text('description')->nullable(); // Description
            $table->date('due_date')->nullable(); // Date d'échéance
            $table->enum('priority', ['low', 'medium', 'high']); // Priorité
            $table->enum('status', ['open', 'closed'])->default('open'); // Statut de la tâche
            $table->timestamps();
        });

        Schema::create('task_user', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->primary(['task_id', 'user_id']);
        });

        Schema::create('task_dependencies', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained();
            $table->foreignId('dependent_task_id')->constrained('tasks');
            $table->primary(['task_id', 'dependent_task_id']);
        });

        Schema::create('task_labels', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained();
            $table->foreignId('label_id')->constrained(); // Assure-toi que tu as une table 'labels'
            $table->primary(['task_id', 'label_id']);
        });

        Schema::create('task_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_tables');
    }
};
