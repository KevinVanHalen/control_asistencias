@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    <span class="styleDate">{{$dia}}</span>                    
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center pt-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span>Asistencias del día</span>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Empleado</th>
                                {{-- <th>Entrada</th> --}}
                                <th>Hora Entrada</th>
                                {{-- <th>Salida</th> --}}
                                <th>Hora Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($array_asistencias as $asistencia)
                                <tr>
                                    <td>{{ $asistencia->num }}</td>
                                    <td>{{ $asistencia->empleado }}</td>
                                    <td>{{ $asistencia->hora_entrada }}</td>
                                    <td>{{ $asistencia->hora_salida }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
