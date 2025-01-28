<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Ciclo;

class UsersCiclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Vacio la tabla users_ciclos
        DB::table('users_ciclos')->truncate();
        // Obtengo todos los usuarios y ciclos
        $users = User::all();
        $ciclos = Ciclo::all();
        // Obtener el número de usuarios y ciclos disponibles
        $numUsers = $users->count();
        $numCiclos = $ciclos->count();
        // Establecer un límite de inserciones
        $limit = min($numUsers, $numCiclos);
        // Asignar ciclos aleatorios a cada usuario hasta el límite
        foreach ($users as $user) {
            if ($limit <= 0) {
                break;
            }
            // Obtengo los IDs de ciclos aleatorios
            $ciclosToAttach = $ciclos->random(rand(1, min(3, $numCiclos)))->pluck('id')->toArray();
            // Asigno los ciclos al usuario
            $user->ciclos()->attach($ciclosToAttach);
            // Decremento el límite
            $limit--;
        }
    }
}
