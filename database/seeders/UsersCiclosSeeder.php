<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ciclo;

class UsersCiclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //Obtengo todos los usuarios y ciclos
        $users = User::all();
        $ciclos = Ciclo::all();

        //Asgino los ciclos a cada usuario de manera aleatoria
       foreach ($users as $user) {
            $user->ciclos()->attach(
                $ciclos->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
