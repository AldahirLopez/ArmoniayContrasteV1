<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-{{ $isEdit ?? false ? 'warning' : 'primary' }} text-white">
                <h5 class="modal-title" id="{{ $modalId }}Label">
                    {{ $isEdit ?? false ? 'Actualizar Dirección' : 'Agregar Dirección' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="{{ $formId }}" method="POST" action="{{ $action }}">
                @csrf
                @if(isset($isEdit) && $isEdit)
                <input type="hidden" name="direccion_id" id="direccion_id_editar">
                @endif

                <input type="hidden" name="tipo_direccion" id="{{ $isEdit ?? false ? 'tipo_direccion_editar' : 'tipo_direccion_agregar' }}">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="entidad_federativa_id_{{ $isEdit ?? false ? 'editar' : 'agregar' }}" class="form-label">Estado</label>
                                <select name="entidad_federativa_id" id="entidad_federativa_id_{{ $isEdit ?? false ? 'editar' : 'agregar' }}" class="form-control" required>
                                    <option value="">Selecciona un estado</option>
                                    @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="municipio_id_{{ $isEdit ?? false ? 'editar' : 'agregar' }}" class="form-label">Municipio</label>
                                <select name="municipio_id" id="municipio_id_{{ $isEdit ?? false ? 'editar' : 'agregar' }}" class="form-control" required>
                                    <option value="">Selecciona un municipio</option>
                                    <!-- Los municipios se cargarán dinámicamente -->
                                </select>
                            </div>
                        </div>

                        @foreach ([
                        'calle' => 'Calle',
                        'numero_ext' => 'Número Exterior',
                        'numero_int' => 'Número Interior',
                        'colonia' => 'Colonia',
                        'codigo_postal' => 'Código Postal',
                        'localidad' => 'Localidad'
                        ] as $field => $label)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="{{ $field }}_{{ $isEdit ?? false ? 'editar' : 'agregar' }}" class="form-label">{{ $label }}</label>
                                <input type="text"
                                    name="{{ $field }}"
                                    id="{{ $field }}_{{ $isEdit ?? false ? 'editar' : 'agregar' }}"
                                    class="form-control"
                                    {{ $field !== 'numero_int' ? 'required' : '' }}>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-{{ $isEdit ?? false ? 'warning' : 'primary' }}">
                        {{ $isEdit ?? false ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>