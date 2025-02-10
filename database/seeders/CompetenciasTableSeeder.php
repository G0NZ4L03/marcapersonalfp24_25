<?php

namespace Database\Seeders;

use App\Models\Competencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Competencia::truncate();

        if(Competencia::count() == 0) {
            if(config('app.env') ==='local'){
                Competencia::factory(10)->create();
                Competencia::factory()->create([
                'nombre' => 'Prueba Nombre',
                'color' => 'colorPrueba'

                ]);
            }
        }
    }
}
