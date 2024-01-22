@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pb-4">
        <div class="col-md-8 col-10">
            <div class="card">
                <div class="card-header text-center">
                    <span class="styleDate">Control de Asistencia</span>                    
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center pt-4">
        <div class="col-md-8 col-10">
            <div class="card">
                <div class="card-body">
                    <input class="norequired" style="display: none;" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nombre" class="form-label">Ingresa tu nombre(s)</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" autofocus>
                            <label id="nombre_required" style="display:none; color: red; font-size: 0.75rem">Campo obligatorio</label>
                        </div>
                    </div>

                    <div class="text-center">
                        <button onclick="registrarAsistencia()" type="button" class="btn btn-secondary">CHECK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function registrarAsistencia() {
        let datos_llenos = true

        let nombre = document.getElementById('nombre')
        if (nombre.value == '') {
            document.getElementById('nombre_required').style.display = 'block'
            datos_llenos = false
        } else {
            document.getElementById('nombre_required').style.display = 'none'
        }

        if (datos_llenos) {
            let data = JSON.stringify({
                'nombre': nombre.value
            })

            try {
                let res = await fetch('/registrar-asistencia', {
                    method: 'post',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": document.getElementById('csrf-token').value
                    },
                    body: data
                })
                .then(res => res.text())
                .then(async html => {
                    let response = JSON.parse(html)
                    if (response.status == "ok") {
                        let audio = new Audio('bites-ta-da-winner.mp3');
                        await audio.play();
                        alert(response.message)
                        nombre.value = ''
                    } else {
                        let audio = new Audio('error-fallo-1.mp3');
                        await audio.play();
                        alert(response.message)
                    }
                })
            } catch (error) {
                
            }

        }
    }
</script>
@endsection