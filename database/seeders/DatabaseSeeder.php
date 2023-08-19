<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Status::create([
             'description' => 'Pendiente',
        ]);

        \App\Models\Status::create([
            'description' => 'Realizada',
        ]);

        \App\Models\Status::create([
            'description' => 'Cancelada',
        ]);
    }
}
