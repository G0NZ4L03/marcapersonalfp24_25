<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministradoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('administradores')->truncate();

            $users = User::all();
            $user = $users->random();

            Administrador::create([
                'id' => $user->id,
                'email' => $user->email,
                'user_id' => $user->id,
            ]);
    }
}
