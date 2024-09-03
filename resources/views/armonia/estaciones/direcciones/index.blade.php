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
                            <a href="{{route('estaciones.listar')}}" class="btn btn-danger">
                                <i class="bi bi-arrow-return-left"></i>
                            </a>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    @foreach (['Tipo de Dirección', 'Calle', 'Número Exterior', 'Número Interior', 'Colonia', 'Código Postal', 'Localidad', 'Municipio', 'Estado', 'Acciones'] as $header)
                                    <th scope="col">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (['fiscal' => $estacion->direccionFiscal, 'servicio' => $estacion->direccionServicio] as $tipo => $direccion)
                                <tr>
                                    <td>{{ ucfirst($tipo) }}</td>
                                    @if($direccion)
                                    @foreach (['calle', 'numero_ext', 'numero_int', 'colonia', 'codigo_postal', 'localidad'] as $campo)
                                    <td>{{ $direccion->$campo }}</td>
                                    @endforeach
                                    <td>{{ optional($direccion->municipio)->description }}</td>
                                    <td>{{ optional($direccion->estado)->description }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#direccionModal" data-tipo="{{ $tipo }}" data-id="{{ $direccion->id_direccion }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                    </td>
                                    @else
                                    <td colspan="8">No hay dirección {{ $tipo }} registrada</td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarDireccionModal" data-tipo="{{ $tipo }}">
                                            <i class="bi bi-plus-circle"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('armonia.estaciones.partials.direccion-modal', [
'modalId' => 'agregarDireccionModal',
'modalTitle' => 'Agregar Dirección',
'btnClass' => 'btn-primary',
'btnText' => 'Guardar',
'formId' => 'agregarDireccionForm',
'action' => route('direcciones.store', $estacion->id_estacion),
])

@include('armonia.estaciones.partials.direccion-modal', [
'modalId' => 'direccionModal',
'modalTitle' => 'Editar Dirección',
'btnClass' => 'btn-warning',
'btnText' => 'Actualizar',
'formId' => 'editarDireccionForm',
'action' => route('direcciones.store', $estacion->id_estacion),
'isEdit' => true
])

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const agregarDireccionModal = document.getElementById('agregarDireccionModal');

        agregarDireccionModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const tipo = button.getAttribute('data-tipo');

            // Configurar el tipo de dirección en el formulario de agregar
            document.getElementById('tipo_direccion_agregar').value = tipo;

            // Limpiar los campos del formulario de agregar dirección
            document.getElementById('agregarDireccionForm').reset();
        });

        const direccionModal = document.getElementById('direccionModal');
        direccionModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const direccionId = button.getAttribute('data-id');
            const tipo = button.getAttribute('data-tipo');

            // Configurar el formulario para el tipo y el ID de la dirección
            document.getElementById('tipo_direccion_editar').value = tipo;
            document.getElementById('direccion_id_editar').value = direccionId;

            // Limpiar y cargar el formulario con los datos existentes
            document.getElementById('editarDireccionForm').reset();

            // Fetch para obtener los datos actuales de la dirección
            fetch(`/direcciones/${direccionId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error al cargar los datos de la dirección:', data.error);
                        return;
                    }

                    // Completar el formulario con los datos existentes
                    const estadoSelect = document.getElementById('entidad_federativa_id_editar');
                    const municipioSelect = document.getElementById('municipio_id_editar');

                    estadoSelect.value = data.entidad_federativa_id;

                    // Cargar municipios dinámicamente y luego preseleccionar el correcto
                    loadMunicipios(estadoSelect, municipioSelect).then(() => {
                        municipioSelect.value = data.municipio_id;
                    });

                    // Completar los demás campos del formulario
                    document.getElementById('calle_editar').value = data.calle || '';
                    document.getElementById('numero_ext_editar').value = data.numero_ext || '';
                    document.getElementById('numero_int_editar').value = data.numero_int || '';
                    document.getElementById('colonia_editar').value = data.colonia || '';
                    document.getElementById('codigo_postal_editar').value = data.codigo_postal || '';
                    document.getElementById('localidad_editar').value = data.localidad || '';
                })
                .catch(error => console.error('Error al cargar los datos de la dirección:', error));
        });

        // Cargar municipios dinámicamente
        const loadMunicipios = (select, target) => {
            return new Promise((resolve, reject) => {
                select.addEventListener('change', function() {
                    const estadoId = this.value;
                    target.innerHTML = '<option value="">Selecciona un municipio</option>';
                    if (estadoId) {
                        fetch(`/municipios/${estadoId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(municipio => {
                                    const option = document.createElement('option');
                                    option.value = municipio.id;
                                    option.textContent = municipio.description;
                                    target.appendChild(option);
                                });
                                resolve();
                            })
                            .catch(error => {
                                console.error('Error al cargar los municipios:', error);
                                reject(error);
                            });
                    }
                });

                // Trigger the change event manually to load municipios on edit modal load
                select.dispatchEvent(new Event('change'));
            });
        };

        loadMunicipios(document.getElementById('entidad_federativa_id_agregar'), document.getElementById('municipio_id_agregar'));
        loadMunicipios(document.getElementById('entidad_federativa_id_editar'), document.getElementById('municipio_id_editar'));
    });
</script>
@endsection