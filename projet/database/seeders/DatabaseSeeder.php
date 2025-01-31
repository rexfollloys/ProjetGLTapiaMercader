<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Appel aux seeders spécifiques
        $this->call([
            AdminSeeder::class,
        ]);
    }
}
