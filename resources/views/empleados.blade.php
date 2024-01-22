@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    <span class="styleDate">Empleados</span>                    
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center pt-4">
        <div class="col-3 text-center">
            <button data-bs-toggle="modal" data-bs-target="#nuevoEmpleado">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                </svg>
                Nuevo
            </button>
        </div>
    </div>

    <div class="row justify-content-center pt-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Estatus</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $empleado)
                                <tr>
                                    <td>{{$empleado->id}}</td>
                                    <td><p>{{$empleado->nombre}} {{$empleado->apellido_paterno}} {{$empleado->apellido_materno}}</p></td>
                                    <td><p class="{{$empleado->status == true ? 'activeEmployeer' : 'inactiveEmployeer'}}">{{$empleado->status == true ? 'Activo' : 'Inactivo'}}</p></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6 col-12 text-center">
                                                <a onclick="setDatosEmpleado({{ $empleado}})" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editarEmpleado"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                  </svg></a>
                                            </div>
                                            <div class="col-md-6 col-12 text-center">
                                                @if($empleado->status == 1)
                                                    <form id="formDeshabilitarEmpleado" action="{{ route('empleado.disabled', ['id' => $empleado->id]) }}" method="POST">
                                                        @csrf
                                                        <a onclick="deshabilitarEmpleado()" type="submit" style="cursor: pointer;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                            </svg>
                                                        </a>
                                                    </form>
                                                @else
                                                    <form id="formHabilitarEmpleado" action="{{ route('empleado.enabled', ['id' => $empleado->id]) }}" method="POST">
                                                        @csrf
                                                        <a onclick="habilitarEmpleado()" style="cursor: pointer;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/>
                                                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/>
                                                            </svg>
                                                        </a>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="nuevoEmpleado" tabindex="-1" aria-labelledby="nuevoEmpleado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formNuevoEmpleado" action="{{ route('empleado.add') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEmpleado">Nuevo Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6 col-12">
                            <label for="editarApellidoPaterno" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="editarApellidoPaterno" name="apellido_paterno">
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="editarApellidoMaterno" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="editarApellidoMaterno" name="apellido_materno">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="editarNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre">
                            <label id="nombre_required" style="display:none; color: red; font-size: 0.75rem">Campo obligatorio</label>
                        </div>
                    </div>
                </div>
                {{-- <input type="text" style="display: none;" class="form-control" id="idEmpleado" name="id_empleado"> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button onclick="addEmpleado()" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editarEmpleado" tabindex="-1" aria-labelledby="editarEmpleado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formEditarEmpleado" action="{{ route('empleado.update') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEmpleado">Actualizar datos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6 col-12">
                            <label for="editarApellidoPaterno" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="editarApellidoPaterno" name="apellido_paterno">
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="editarApellidoMaterno" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="editarApellidoMaterno" name="apellido_materno">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="editarNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre">
                            <label id="nombre_required" style="display:none; color: red; font-size: 0.75rem">Campo obligatorio</label>
                        </div>
                    </div>
                </div>
                <input type="text" style="display: none;" class="form-control" id="idEmpleado" name="id_empleado">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button onclick="updateDatosEmpleado()" type="button" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        function setDatosEmpleado(empleado) {
            document.getElementById('editarApellidoPaterno').value = empleado.apellido_paterno
            document.getElementById('editarApellidoMaterno').value = empleado.apellido_materno
            document.getElementById('editarNombre').value = empleado.nombre
            document.getElementById('idEmpleado').value = empleado.id
        }

        function updateDatosEmpleado() {
            event.preventDefault()

            let datos_llenos = true

            let nombre = document.getElementById('editarNombre')
            if (nombre.value == '') {
                document.getElementById('nombre_required').style.display = 'block'
                datos_llenos = false
            } else {
                document.getElementById('nombre_required').style.display = 'none'
            }

            if (datos_llenos) {
                document.getElementById('formEditarEmpleado').submit()
            }
        }

        function deshabilitarEmpleado() {
            document.getElementById('formDeshabilitarEmpleado').submit()
        }

        function habilitarEmpleado() {
            document.getElementById('formHabilitarEmpleado').submit()
        }

        function addEmpleado() {
            event.preventDefault()

            let datos_llenos = true

            let nombre = document.getElementById('editarNombre')
            if (nombre.value == '') {
                document.getElementById('nombre_required').style.display = 'block'
                datos_llenos = false
            } else {
                document.getElementById('nombre_required').style.display = 'none'
            }

            if (datos_llenos) {
                document.getElementById('formNuevoEmpleado').submit()
            }
        }
    </script>
@endsection