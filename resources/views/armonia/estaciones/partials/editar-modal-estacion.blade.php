<div class="modal fade" id="editarEstacionModal-{{ $estacion->id_estacion }}" tabindex="-1" aria-labelledby="editarEstacionModalLabel-{{ $estacion->id_estacion }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editarEstacionModalLabel-{{ $estacion->id_estacion }}">Editar Estación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarEstacionForm-{{ $estacion->id }}" action="{{ route('estaciones.update', $estacion->id_estacion) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="mb-3">
                            <label for="numestacion-{{ $estacion->id }}" class="form-label">Número de estación</label>
                            <input type="text" name="numestacion" class="form-control" id="numestacion-{{ $estacion->id }}" value="{{ $estacion->num_estacion }}" required>
                            @error('numestacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="razonsocial-{{ $estacion->id }}" class="form-label">Razón Social</label>
                            <input type="text" name="razonsocial" class="form-control" id="razonsocial-{{ $estacion->id }}" value="{{ $estacion->razon_social }}" required>
                            @error('razonsocial')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="rfc-{{ $estacion->id }}" class="form-label">RFC</label>
                            <input type="text" name="rfc" class="form-control" id="rfc-{{ $estacion->id }}" value="{{ $estacion->rfc }}" required>
                            @error('rfc')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado-{{ $estacion->id }}" class="form-label">Estado</label>
                            <select name="estado" class="form-select" id="estado-{{ $estacion->id }}" required>
                                @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" {{ $estado->id == $estacion->estado_id ? 'selected' : '' }}>{{ $estado->description }}</option>
                                @endforeach
                            </select>
                            @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>