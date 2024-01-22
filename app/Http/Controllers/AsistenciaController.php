<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Empleado;
use Carbon\Carbon;
use Session;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::all();
        
        return view('asistencias')->with(compact('asistencias'));
    }

    public function registro()
    {
        return view('registro');
    }
    
    public function registrarAsistencia(Request $request)
    {
        $exito = false;
        $entrada = false;
        $salida = false;
        DB::beginTransaction();

        try {
            $currentDate = Carbon::now();

            $empleado = Empleado::where('nombre', $request->nombre)->first();
            
            if (!$empleado) {
                return response()->json([
                    "status" => "warning",
                    "message" => "Empleado no existe, por favor revisa que tu nombre este bien escrito.",
                ], 200);
            }

            $existe_asistencia_hoy = Asistencia::where('empleado_id', $empleado->id)
                                                ->where('fecha', $currentDate->toDateString())
                                                ->first();

                                                
            if ($existe_asistencia_hoy) {
                if ($existe_asistencia_hoy->check_in && $existe_asistencia_hoy->check_out) {
                    return response()->json([
                        "status" => "ok",
                        "message" => "Ya has registrado anteriormente tu entrada y salida del día de hoy"
                    ], 200);
                }

                $fecha_hora_registro = Carbon::parse($existe_asistencia_hoy->fecha . ' ' . $existe_asistencia_hoy->hora_entrada);
                
                $existe_asistencia_hoy->hora_salida = $currentDate->toTimeString();
                $existe_asistencia_hoy->check_out = true;
                $existe_asistencia_hoy->correct_check = true;
                $existe_asistencia_hoy->save();

                $salida = true;
            } else {
                $asistencia = new Asistencia;
                $asistencia->fecha = $currentDate->toDateString();
                $asistencia->hora_entrada = $currentDate->toTimeString();
                $asistencia->check_in = true;
                $asistencia->empleado_id = $empleado->id;
                $asistencia->save();

                $entrada = true;
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al registrar asistencia.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            if ($entrada == true) {
                return response()->json([
                    "status" => "ok",
                    "message" => "Hola " . $empleado->nombre . ' ' . $empleado->apellido_paterno . ' ' . $empleado->apellido_materno . ". \nEntrada registrada con éxito.",
                    "empleado" => $empleado,
                ], 200);
            } else if ($salida == true) {
                return response()->json([
                    "status" => "ok",
                    "message" => "Adiós " . $empleado->nombre . ' ' . $empleado->apellido_paterno . ' ' . $empleado->apellido_materno . ". \nSalida registrada con éxito.",
                    "empleado" => $empleado,
                ], 200);
            }
        }
    }

    public function asistenciasHoy()
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
