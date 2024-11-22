@extends('layouts.user')
@section('content')

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path
            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path
            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
</svg>

<ul class="container nav justify-content-end mt-2 py-2">
    @auth
    <li class="nav-item">
        <a href="{{ url('/dashboard') }}"
            class="linkJv rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Dashboard
        </a>
    </li>
    @else
    <li class="nav-item">
        <a href="{{ route('login') }}"
            class="linkJv rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Ingresar
        </a>
    </li>
    @if (Route::has('register'))
    <li class="nav-item">
        <a href="{{ route('register') }}"
            class="linkJv rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Registrarme
        </a>
    </li>
    @endif

    <li class="nav-item">
        <a href="#" class="linkJv" id="toastbtn">Notificacion</a>
    </li>

    @endauth
</ul>

<main class="container mt-2 py-5">
    <div class="container text-center grid gap-6 lg:grid-cols-2 lg:gap-8">
        <div class="container row row-cols-1 row-cols-md-1 g-4">
            <div class="col">
                <div class="card text-white bg-secondary" style="height: 100%;max-width: 100%;">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <h1 class="card-title" style="font-size: 70px">{{ $data->ntFish }}</h1>
                        <h5>Notas contretadas</h5>
                        <div class="row row-cols-1 row-cols-md-1 py-3">
                            <p class="card-text" style="font-size: 20px">Cantidad de notas: <span>{{ $data->ntCant
                                    }}</span></p>
                            <p class="card-text" style="font-size: 20px">Notas canceladas: <span>{{ $data->ntfail
                                    }}</span></p>
                            <p class="card-text" style="font-size: 20px">Notas de prueba: <span>{{ $data->ntTest
                                    }}</span></p>
                        </div>
                    </div>
                    <div class="card-footer row row-cols-2 row-cols-md-2">
                        <div class="col text-end">
                            <a class="btn btn-danger text-center" href="#">Reportar fallo</a>
                        </div>
                        <div class="col text-start">
                            <a class="btn btn-primary text-center" data-bs-toggle="modal"
                                data-bs-target="#modalTest">Realizar prueba</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toastNotice" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Alerta</strong>
            <small id="textHora"></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Nueva nota cancelada.
        </div>
    </div>
</div>

<!-- MODAL TEST -->
<div class="modal fade" id="modalTest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Informacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sendTest') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger align-items-center" role="alert">
                        <div class="container row row-cols-1 row-cols-md-1 g-4">
                            <div class="col">
                                <h4 style="font-size: 26px">
                                    <label class="">
                                        <svg class="" width="24" height="24" role="img" aria-label="Danger:">
                                            <use xlink:href="#exclamation-triangle-fill" />
                                        </svg>
                                    </label>
                                    Atencion
                                </h4>
                            </div>
                            <div class="col">
                                <label>
                                    Para poder realizar un test debe aceptar los terminos y condiciones.
                                </label>
                            </div>
                            <div class="col">
                                <div class="container form-check">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <input class="form-check-input" type="checkbox" value="test" id="status"
                                            name="status" required>
                                        Acepta los terminos y condiciones.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function msg(){
            momentoActual = new Date() 
            hora = momentoActual.getHours() 
            minuto = momentoActual.getMinutes() 
            segundo = momentoActual.getSeconds() 

            horaImprimible = hora + " : " + minuto + " : " + segundo 
            document.querySelector('#textHora').innerText = horaImprimible;
        }

        document.getElementById("toastbtn").onclick = function() {
            msg();
            var myAlert =document.getElementById('toastNotice');
            var bsAlert = new bootstrap.Toast(myAlert);
            bsAlert.show();
        };


</script>

<footer class="py-16 text-center text-sm text-black dark:text-white/70 text-white">
    Notas v{{ Illuminate\Foundation\Application::VERSION }} (Core v{{ PHP_VERSION }})
    <br>
</footer>

@endsection