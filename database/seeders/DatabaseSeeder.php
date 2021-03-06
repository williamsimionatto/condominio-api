<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        \App\Models\Perfil::factory(1)->create();
        \App\Models\Permissao::factory(2)->create();
        \App\Models\User::factory(1)->create();
        \App\Models\Period::factory(1)->create();
    }
}
