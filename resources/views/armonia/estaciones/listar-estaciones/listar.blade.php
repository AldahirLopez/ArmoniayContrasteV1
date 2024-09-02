@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Estaciones de servicio</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('estaciones.index') }}" class="btn btn-danger"><i class="bi bi-arrow-return-left"></i></a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarEstacionModal">
                                Generar Nueva Estación
                            </button>
                        </div>

                        <input type="text" id="buscarEstacion" class="form-control mb-3" placeholder="Buscar estación...">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Número de estación</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Direcciones</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaEstaciones">
                                @foreach($estaciones as $estacion)
                                <tr>
                                    <td>{{ $estacion->num_estacion }}</td>
                                    <td>{{ $estacion->razon_social }}</td>
                                    <td>{{ $estacion->estado->description }}</td>
                                    <td>
                                        <a href="{{ route('direcciones.index', $estacion->id_estacion) }}" class="btn btn-info">
                                            <i class="bi bi-eye"></i> Ver Direcciones
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarEstacionModal-{{ $estacion->id_estacion }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        @can('delete', $estacion)
                                        <form action="{{ route('estaciones.destroy', $estacion->id_estacion) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta estación? Esta acción no se puede deshacer.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Eliminar">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>



                                <!-- Incluir el Partial del Modal de Edición -->
                                @include('armonia.estaciones.partials.editar-modal-estacion', ['estacion' => $estacion, 'estados' => $estados])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para generar nueva estación -->
    @include('armonia.estaciones.partials.generar-modal-estacion', ['estados' => $estados, 'usuario' => $usuario])


</section>
@endsection