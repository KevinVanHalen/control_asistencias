<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $current_date = Carbon::now();
        $dia = $this->getDay($current_date);

        $cont = 0;
        $asistencias = Asistencia::where('fecha', $current_date->toDateString())->get();
        $array_asistencias = array();
        foreach ($asistencias as $asistencia) {
            $cont = $cont + 1;

            $object = new \stdClass();
            $object->id = $asistencia->id;
            $object->num = $cont;
            $object->empleado = $asistencia->empleado->nombre . ' ' . $asistencia->empleado->apellido_paterno . ' ' . $asistencia->empleado->apellido_materno;
            $object->hora_entrada = $asistencia->hora_entrada;
            $object->hora_salida = $asistencia->hora_salida;
            
            array_push($array_asistencias, $object);
        }

        // $array_asistencias = array_reverse($array_asistencias);

        return view('home')->with(compact('current_date', 'dia', 'array_asistencias'));
    }

    public function getDay($date)
    {
        $formatted_date = '';
        $day_of_week = '';
        $month_of_year = '';

        // Get day of week formatted
        switch ($date->dayOfWeek) {
            case 0:
                $day_of_week = 'Domingo';
                break;
            case 1:
                $day_of_week = 'Lunes';
                break;
            case 2:
                $day_of_week = 'Martes';
                break;
            case 3:
                $day_of_week = 'Miércoles';
                break;
            case 4:
                $day_of_week = 'Jueves';
                break;
            case 5:
                $day_of_week = 'Viernes';
                break;
            case 6:
                $day_of_week = 'Sábado';
                break;
        }

        // Get month of year formatted
        switch($date->month) {
            case 1:
                $month_of_year = 'Enero';
                break;
            case 2:
                $month_of_year = 'Febrero';
                break;
            case 3:
                $month_of_year = 'Marzo';
                break;
            case 4:
                $month_of_year = 'Abril';
                break;
            case 5:
                $month_of_year = 'Mayo';
                break;
            case 6:
                $month_of_year = 'Junio';
                break;
            case 7:
                $month_of_year = 'Julio';
                break;
            case 8:
                $month_of_year = 'Agosto';
                break;
            case 9:
                $month_of_year = 'Septiembre';
                break;
            case 10:
                $month_of_year = 'Octubre';
                break;
            case 11:
                $month_of_year = 'Noviembre';
                break;
            case 12:
                $month_of_year = 'Diciembre';
                break;
        }

        $formatted_date = $day_of_week . ', ' . $date->day . ' de ' . $month_of_year . ' del ' . $date->year;

        return $formatted_date;
    }
}
