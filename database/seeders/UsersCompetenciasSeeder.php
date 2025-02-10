<?php

namespace Database\Seeders;

use App\Models\Competencia;
use App\Models\User;
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
        DB::table('users_competencias')->truncate();

        // Obtener todos los usuarios y competencias
        $users = User::all();
        $competencias = Competencia::all();

        foreach ($users as $user) {
            $numCompetencias = rand(0, 2);
            $numCompetencias = min($numCompetencias, $competencias->count());

            if ($numCompetencias > 0) {
                $randomCompetencias = $competencias->random($numCompetencias);

                foreach ($randomCompetencias as $competencia) {
                    $user->competencias()->attach($competencia->id, [
                        'docente_validador' => User::inRandomOrder()->first()->id
                    ]);
                }
            }
        }
    }
}
