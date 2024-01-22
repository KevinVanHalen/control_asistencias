<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Contreras',
            'apellido_materno' => 'López',
            'nombre' => 'Filomena',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => '',
            'apellido_materno' => '',
            'nombre' => 'Imelda',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Sánchez',
            'apellido_materno' => 'Zaragoza',
            'nombre' => 'Yareidy',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'García',
            'apellido_materno' => 'Romero',
            'nombre' => 'Laura',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Salgado',
            'apellido_materno' => 'García',
            'nombre' => 'Rigoberto',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Romero',
            'apellido_materno' => 'Lozano',
            'nombre' => 'Martha',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Aparicio',
            'apellido_materno' => 'Aguilar',
            'nombre' => 'Areli',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Mota',
            'apellido_materno' => 'Preza',
            'nombre' => 'Vicente',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'De la Luz',
            'apellido_materno' => 'Barrios',
            'nombre' => 'María',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Aparicio',
            'apellido_materno' => 'Díaz',
            'nombre' => 'Masari',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Romero',
            'apellido_materno' => 'Sánchez',
            'nombre' => 'Ivan',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'López',
            'apellido_materno' => 'Francisco',
            'nombre' => 'Abigail',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Medina',
            'apellido_materno' => 'Aguilar',
            'nombre' => 'Elisa',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => 'Bravo',
            'apellido_materno' => 'Sandoval',
            'nombre' => 'Deni',
        ]);
        DB::table('empleados')->insert([
            'apellido_paterno' => '',
            'apellido_materno' => '',
            'nombre' => 'Cari',
        ]);
    }
}
