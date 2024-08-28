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
                        <div style="margin-block-start: 15px;">
                            <a href="#" class="btn btn-danger"><i class="bi bi-arrow-return-left"></i></a>

                            <!-- Botón que abre el modal para generar nueva estación -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#generarEstacionModal">
                                Generar Nueva Estacion
                            </button>

                        </div>

                        <input style="margin-block-start: 15px;" type="text" id="buscarEstacion" class="form-control mb-3" placeholder="Buscar estación...">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Número de estación</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Servicios</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaEstaciones">
                                @foreach($estaciones as $estacion)
                                <tr>
                                    <td>{{ $estacion->num_estacion }}</td>
                                    <td>{{ $estacion->razon_social }}</td>
                                    <td>{{ $estacion->estado_republica_estacion }}</td>
                                    <td>Botón a servicios</td>
                                    <td>
                                        <!-- Botón para editar estación -->
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editarEstacionModal-{{ $estacion->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        @if(auth()->check() && auth()->user()->hasRole('Administrador'))
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['estaciones.destroy', $estacion->id_estacion], 'style' => 'display:inline']) !!}
                                        {!! Form::button('<i class="bi bi-trash-fill"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'title' => 'Eliminar']) !!}
                                        {!! Form::close() !!}
                                        @endif
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
    </div>

    <!-- Modal para generar nueva estación -->
    <div class="modal fade" id="generarEstacionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Generar Nueva Estación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de generación de estación -->
                    <form id="generarEstacionForm" action="{{ route('estaciones.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_usuario" value="{{ strtoupper($usuario->id) }}">
                        <input type="hidden" name="fecha_actual" value="{{ date('d/m/Y') }}">

                        <div class="row">
                            <div class="mb-3">
                                <label for="numestacion" class="form-label">Número de estación</label>
                                <input type="text" name="numestacion" class="form-control" required value="{{ old('numestacion') }}">
                                @error('numestacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="razonsocial" class="form-label">Razón Social</label>
                                <input type="text" name="razonsocial" class="form-control" required value="{{ old('razonsocial') }}">
                                @error('razonsocial')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="rfc" class="form-label">RFC</label>
                                <input type="text" name="rfc" class="form-control" required value="{{ old('rfc') }}">
                                @error('rfc')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" class="form-select" required>
                                    @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->description }}</option>
                                    @endforeach
                                </select>
                                @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection