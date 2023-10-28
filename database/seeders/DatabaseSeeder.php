<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Livro;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Livro::factory(10)->create();

        \App\Models\Livro::factory()->create([
            'titulo' => 'O pequeno principe',
            'autor' => 'Aquele lá',
            'descricao' => 'Livro dahora, lê ai',
            'editora' => 'Aquela',
            'genero' => 'sim',
        ]);
    }
}
