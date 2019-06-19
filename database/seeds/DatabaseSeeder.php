<?php

use Illuminate\Database\Seeder;
use App\Persona;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Persona::class,15)->create();

    }
}
