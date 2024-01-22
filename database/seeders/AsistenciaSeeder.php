<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = Carbon::now();

        DB::table('asistencias')->insert([
            'fecha' => $currentDate->toDateString(),
            'hora_entrada' => $currentDate->toTimeString(),
            'empleado_id' => 1,
        ]);
    }
}
