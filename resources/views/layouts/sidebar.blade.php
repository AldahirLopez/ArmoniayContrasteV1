<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if(auth()->check() && auth()->user()->hasRole(['Administrador']))
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#usuarios-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="usuarios-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('usuarios.index') }}">
                        <i class="bi bi-circle"></i><span>Ver Usuarios</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#roles-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-shield-lock-fill"></i><span>Roles</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="roles-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('roles.index') }}">
                        <i class="bi bi-circle"></i><span>Ver Roles</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- End Components Nav -->
        <li class="nav-heading">Paginas</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('estaciones.index') }}">
                <i class="bx bxs-data"></i>
                <span>Estaciones de servicio</span>
            </a>
        </li>
        @endif

        @if(auth()->check() && auth()->user()->hasRole(['Verificador Anexo 30']))
        <!-- End Components Nav -->
        <li class="nav-heading">Paginas</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('estaciones.index') }}">
                <i class="bx bxs-data"></i>
                <span>Estaciones de servicio</span>
            </a>
        </li>
        @endif
    </ul>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="darkModeSwitch">
        <label class="form-check-label" for="darkModeSwitch">Modo Oscuro</label>
    </div>

</aside>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const darkModeSwitch = document.getElementById('darkModeSwitch');

        // Verifica si el modo oscuro está activado en el localStorage
        if (localStorage.getItem('dark-mode') === 'true') {
            document.body.classList.add('dark-mode');
            darkModeSwitch.checked = true;
        }

        darkModeSwitch.addEventListener('change', function() {
            if (this.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('dark-mode', 'true');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('dark-mode', 'false');
            }
        });
    });
</script>