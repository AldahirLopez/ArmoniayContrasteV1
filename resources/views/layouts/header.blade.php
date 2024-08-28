@php
use Illuminate\Support\Facades\Auth;
@endphp

<style>
    .logo img {
        max-height: 50px;
        /* Ajusta el tamaño según sea necesario */
        margin-right: 10px;
        /* Espacio entre la imagen y el texto */
    }

    .logo div {
        display: flex;
        flex-direction: column;
    }

    .logo span {
        font-size: 14px;
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta cualquier desbordamiento de texto */
        text-overflow: ellipsis;
        /* Agrega puntos suspensivos si el texto es demasiado largo */
        max-width: 150px;
        /* Ajusta el tamaño según sea necesario */
    }
</style>


<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center flex-column flex-lg-row">
            <img src="{{ asset('assets/img/logoarmonia.png') }}" alt="">
            <div class="d-flex flex-column text-center text-lg-start">
                <span class="d-none d-lg-block">Armonia y Contraste</span>
                <span class="d-none d-lg-block">Ambiental S.A. DE C.V.</span>
            </div>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-4">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">-->
                    @auth
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    @endauth
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        @auth
                        <h6>{{ Auth::user()->name }}</h6>
                        @foreach(Auth::user()->getRoleNames() as $role)
                        <span>{{ $role }}</span>
                        @endforeach
                        @endauth
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        @if (Auth::check() && Route::has('usuarios.showchangepasswordform'))
                        <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('usuarios.showchangepasswordform', ['id' => Auth::user()->id]) }}">
                            <i class="bi bi-person"></i>
                            <span>Cambiar Contraseña</span>
                        </a>
                        @endif
                    </li>



                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Salir</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>