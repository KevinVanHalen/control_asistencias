<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Empleado;
use Session;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::orderBy('id', 'desc')->get();

        return view('empleados')->with((compact('empleados')));
    }

    public function add(Request $request)
    {
        $exito = false;
        DB::beginTransaction();

        try {
            $empleado = new Empleado;
            $empleado->apellido_paterno = $request->apellido_paterno;
            $empleado->apellido_materno = $request->apellido_materno;
            $empleado->nombre = $request->nombre;
            $empleado->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al registrar empleado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            Session::flash('success', 'Empleado registrado con éxito!');
            return redirect()->route('empleados');
        }
    }

    public function update(Request $request)
    {
        $exito = false;
        DB::beginTransaction();

        try {
            $empleado = Empleado::find($request->id_empleado);
            $empleado->apellido_paterno = $request->apellido_paterno;
            $empleado->apellido_materno = $request->apellido_materno;
            $empleado->nombre = $request->nombre;
            $empleado->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar empleado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            Session::flash('success', 'Empleado editado con éxito!');
            return redirect()->route('empleados');
        }
    }

    public function disabled($id)
    {
        $exito = false;
        DB::beginTransaction();

        try {
            $empleado = Empleado::find($id);
            $empleado->status = false;
            $empleado->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al deshabilitar empleado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            Session::flash('success', 'Empleado deshabilitado con éxito!');
            return redirect()->route('empleados');
        }
    }

    public function enabled($id)
    {
        $exito = false;
        DB::beginTransaction();

        try {
            $empleado = Empleado::find($id);
            $empleado->status = true;
            $empleado->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al habilitar empleado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            Session::flash('success', 'Empleado habilitado con éxito!');
            return redirect()->route('empleados');
        }
    }
}
