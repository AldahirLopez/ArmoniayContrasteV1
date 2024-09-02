<div class="modal fade" id="generarEstacionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Generar Nueva Estación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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