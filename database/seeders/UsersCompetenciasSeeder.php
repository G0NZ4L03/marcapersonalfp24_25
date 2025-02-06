<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersCompetenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users-competencias')->truncate();

        DB::table('users-competencias')->insert([
            [
                //TODO asignar los valores relacionados y aleatorios
                //y no que esten asignados 1, 1, 1
                'user_id' => 1,
                'competencia_id' => 1,
                'docente_validador' => 1,
            ],
            [
                //despues ejecutar el seeder
                //php artisan db:seed --class=UserCompetenciasSeeder
                'user_id' => 2,
                'competencia_id' => 2,
                'docente_validador' => 2,
            ],
            [
                //comprobar que esta poblada correctamente la tabla en la BBDD
                'user_id' => 3,
                'competencia_id' => 3,
                'docente_validador' => 3,
            ],
        ]);
    }
}
