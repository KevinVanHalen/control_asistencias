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
}
