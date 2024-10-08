<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Estados\Municipios;
use App\Models\Usuario_Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DireccionesController extends Controller
{
    public function index($idEstacion)
    {
        // Cargar la estación con las relaciones necesarias
        $estacion = Estacion::with([
            'direccionFiscal.municipio',
            'direccionFiscal.estado',
            'direccionServicio.municipio',
            'direccionServicio.estado'
        ])->findOrFail($idEstacion);

        // Filtrar los estados donde id_country es 42 Mexico
        $estados = Estados::where('id_country', 42)->get();

        // Cargar todos los municipios
        $municipios = Municipios::all();

        return view('armonia.estaciones.direcciones.index', compact('estacion', 'estados', 'municipios'));
    }

    public function store(Request $request, $estacionId)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'tipo_direccion' => 'required',
            'calle' => 'required',
            'numero_ext' => 'required',
            'numero_int' => 'nullable',
            'colonia' => 'required',
            'codigo_postal' => 'required',
            'localidad' => 'required',
            'municipio_id' => 'required|exists:segunda_db.municipalities,id',
            'entidad_federativa_id' => 'required|exists:segunda_db.states,id',
            'direccion_id' => 'nullable|exists:segunda_db.direcciones,id_direccion' // Añadido para ediciones
        ]);

        try {
            // Iniciar una transacción para la segunda base de datos
            DB::connection('segunda_db')->beginTransaction();

            // Obtener la estación desde la segunda base de datos 
            $estacion = Estacion::on('segunda_db')->findOrFail($estacionId);

            // Determina el tipo de dirección
            $tipoDireccion = $validatedData['tipo_direccion'];

            // Verifica si ya existe una dirección para el tipo dado
            $direccion = null;

            if (isset($validatedData['direccion_id']) && $validatedData['direccion_id']) {
                // Si se proporciona un ID de dirección, buscamos la dirección para actualizarla
                $direccion = Direccion::on('segunda_db')->findOrFail($validatedData['direccion_id']);
                $direccion->update($validatedData);
            } else {
                // Si no existe, se crea una nueva dirección
                $direccion = Direccion::on('segunda_db')->create($validatedData);
            }

            // Asociar la dirección recién creada o actualizada a la estación
            if ($tipoDireccion === 'fiscal') {
                $estacion->domicilio_fiscal_id = $direccion->id_direccion;
            } elseif ($tipoDireccion === 'servicio') {
                $estacion->domicilio_servicio_id = $direccion->id_direccion;
            }

            // Guarda los cambios en la estación
            $estacion->save();

            // Confirmar la transacción
            DB::connection('segunda_db')->commit();

            // Redirigir a la vista de direcciones de la estación actual
            return redirect()->route('direcciones.index', $estacionId)->with('success', 'Dirección guardada exitosamente.');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::connection('segunda_db')->rollBack();
            return redirect()->back()->with('error', 'Error al guardar la dirección: ' . $e->getMessage());
        }
    }
    public function getMunicipios(Request $request)
    {
        $municipios = Municipios::where('id_state', $request->estado_id)->get();
        return response()->json($municipios);
    }

    public function show($id)
    {
        try {
            $direccion = Direccion::with('municipio', 'estado')->findOrFail($id);
            return response()->json($direccion);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar la dirección: ' . $e->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        // Buscar la dirección por ID
        $direccion = Direccion::on('segunda_db')->find($id);

        if (!$direccion) {
            return response()->json(['error' => 'Dirección no encontrada'], 404);
        }

        // Retornar los datos en formato JSON
        return response()->json($direccion);
    }
}
