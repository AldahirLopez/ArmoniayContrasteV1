@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Direcciones de la Estación: {{ $estacion->num_estacion }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('estaciones.index') }}" class="btn btn-danger"><i class="bi bi-arrow-return-left"></i> Volver</a>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Tipo de Dirección</th>
                                    <th scope="col">Calle</th>
                                    <th scope="col">Número Exterior</th>
                                    <th scope="col">Número Interior</th>
                                    <th scope="col">Colonia</th>
                                    <th scope="col">Código Postal</th>
                                    <th scope="col">Localidad</th>
                                    <th scope="col">Municipio</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Fila para Dirección Fiscal -->
                                <tr>
                                    <td>Fiscal</td>
                                    @if($estacion->direccionFiscal)
                                    <td>{{ optional($estacion->direccionFiscal)->calle }}</td>
                                    <td>{{ optional($estacion->direccionFiscal)->numero_ext }}</td>
                                    <td>{{ optional($estacion->direccionFiscal)->numero_int }}</td>
                                    <td>{{ optional($estacion->direccionFiscal)->colonia }}</td>
                                    <td>{{ optional($estacion->direccionFiscal)->codigo_postal }}</td>
                                    <td>{{ optional($estacion->direccionFiscal)->localidad }}</td>
                                    <td>{{ optional($estacion->direccionFiscal->municipio)->description }}</td>
                                    <td>{{ optional($estacion->direccionFiscal->estado)->description }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#direccionModal" data-tipo="fiscal">
                                            <i class="bi bi-pencil-fill"></i> Editar
                                        </button>
                                    </td>
                                    @else
                                    <td colspan="8">No hay dirección fiscal registrada</td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarDireccionModal" data-tipo="fiscal">
                                            <i class="bi bi-plus-circle"></i> Agregar
                                        </button>
                                    </td>
                                    @endif
                                </tr>

                                <!-- Fila para Dirección de la Estación -->
                                <tr>
                                    <td>Estación</td>
                                    @if($estacion->direccionServicio)
                                    <td>{{ optional($estacion->direccionServicio)->calle }}</td>
                                    <td>{{ optional($estacion->direccionServicio)->numero_ext }}</td>
                                    <td>{{ optional($estacion->direccionServicio)->numero_int }}</td>
                                    <td>{{ optional($estacion->direccionServicio)->colonia }}</td>
                                    <td>{{ optional($estacion->direccionServicio)->codigo_postal }}</td>
                                    <td>{{ optional($estacion->direccionServicio)->localidad }}</td>
                                    <td>{{ optional($estacion->direccionServicio->municipio)->description }}</td>
                                    <td>{{ optional($estacion->direccionServicio->estado)->description }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#direccionModal" data-tipo="servicio">
                                            <i class="bi bi-pencil-fill"></i> Editar
                                        </button>
                                    </td>
                                    @else
                                    <td colspan="8">No hay dirección de la estación registrada</td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarDireccionModal" data-tipo="servicio">
                                            <i class="bi bi-plus-circle"></i> Agregar
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para agregar dirección -->
<div class="modal fade" id="agregarDireccionModal" tabindex="-1" aria-labelledby="agregarDireccionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="agregarDireccionModalLabel">Agregar Dirección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="agregarDireccionForm" method="POST" action="{{ route('direcciones.store', $estacion->id_estacion) }}">
                @csrf
                <div class="modal-body">
                    <!-- Campo oculto para tipo de dirección -->
                    <input type="hidden" name="tipo_direccion" id="tipo_direccion_agregar">

                    <!-- Campo para Estado -->
                    <div class="mb-3">
                        <label for="entidad_federativa_id_agregar" class="form-label">Estado</label>
                        <select name="entidad_federativa_id" id="entidad_federativa_id_agregar" class="form-control" required>
                            <option value="">Selecciona un estado</option>
                            @foreach($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campo para Municipio -->
                    <div class="mb-3">
                        <label for="municipio_id_agregar" class="form-label">Municipio</label>
                        <select name="municipio_id" id="municipio_id_agregar" class="form-control" required>
                            <option value="">Selecciona un municipio</option>
                            <!-- Los municipios se cargarán dinámicamente -->
                        </select>
                    </div>

                    <!-- Resto de los campos del formulario -->
                    <div class="mb-3">
                        <label for="calle_agregar" class="form-label">Calle</label>
                        <input type="text" name="calle" id="calle_agregar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero_ext_agregar" class="form-label">Número Exterior</label>
                        <input type="text" name="numero_ext" id="numero_ext_agregar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero_int_agregar" class="form-label">Número Interior</label>
                        <input type="text" name="numero_int" id="numero_int_agregar" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="colonia_agregar" class="form-label">Colonia</label>
                        <input type="text" name="colonia" id="colonia_agregar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="codigo_postal_agregar" class="form-label">Código Postal</label>
                        <input type="text" name="codigo_postal" id="codigo_postal_agregar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="localidad_agregar" class="form-label">Localidad</label>
                        <input type="text" name="localidad" id="localidad_agregar" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estadoSelectAgregar = document.getElementById('entidad_federativa_id_agregar');
        const municipioSelectAgregar = document.getElementById('municipio_id_agregar');

        estadoSelectAgregar.addEventListener('change', function() {
            const estadoId = this.value;

            // Limpiar el select de municipios
            municipioSelectAgregar.innerHTML = '<option value="">Selecciona un municipio</option>';

            if (estadoId) {
                fetch(`/municipios/${estadoId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(municipio => {
                            const option = document.createElement('option');
                            option.value = municipio.id;
                            option.textContent = municipio.description;
                            municipioSelectAgregar.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al cargar los municipios:', error));
            }
        });

        const agregarDireccionModal = document.getElementById('agregarDireccionModal');
        agregarDireccionModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const tipo = button.getAttribute('data-tipo');

            const tipoDireccionInput = document.getElementById('tipo_direccion_agregar');

            tipoDireccionInput.value = tipo;

            // Limpiar el formulario cuando se abre el modal
            document.getElementById('agregarDireccionForm').reset();
        });
    });
</script>
@endsection