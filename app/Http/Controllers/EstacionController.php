<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Estados\Municipios;
use App\Models\Usuario_Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstacionController extends Controller
{
    protected $connection = 'segunda_db';

    public function index()
    {
        return view('armonia.estaciones.index');
    }

    public function show()
    {
        $usuario = Auth::user();
        $estados = Estados::where('id_country', 42)->get();

        // Obtener las estaciones según el rol del usuario
        $estaciones = $this->obtenerEstacionesPorUsuario($usuario);

        // Obtener todos los municipios relacionados con los estados de las estaciones
        $municipios = Municipios::whereIn('id_state', $estaciones->pluck('estado_id'))->get();

        return view('armonia.estaciones.listar-estaciones.listar', compact('usuario', 'estados', 'estaciones', 'municipios'));
    }

    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $validatedData = $request->validate([
            'numestacion' => 'required|unique:segunda_db.estacion,num_estacion',
            'razonsocial' => 'required|string|max:255',
            'rfc' => 'required|string',
            'estado' => 'required|exists:segunda_db.states,id',
        ], [
            // Personalizar el mensaje de error para numestacion único
            'numestacion.unique' => 'El número de estación ya existe.',
        ]);

        try {
            $idUsuario = Auth::id();

            // Crear la estación con los datos validados
            Estacion::create([
                'num_estacion' => $validatedData['numestacion'],
                'razon_social' => $validatedData['razonsocial'],
                'rfc' => $validatedData['rfc'],
                'estado_id' => $validatedData['estado'],
                'usuario_id' => $idUsuario,
            ]);

            return redirect()->route('estaciones.listar')->with('success', 'Estación creada exitosamente.');
        } catch (\Exception $e) {
            // Capturar cualquier excepción durante la creación y devolver un mensaje de error
            return redirect()->route('estaciones.listar')->with('error', 'Ocurrió un error al crear la estación.');
        }
    }


    public function destroy($id)
    {
        try {
            $estacion = Estacion::findOrFail($id);
            $estacion->delete();

            return redirect()->route('estaciones.index')->with('success', 'Estación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('estaciones.index')->with('error', 'Error al eliminar la estación: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'numestacion' => 'required|string|max:10|unique:segunda_db.estacion,num_estacion,' . $id . ',id_estacion',
            'razonsocial' => 'required|string|max:255',
            'rfc' => 'required|string|max:20',
            'estado' => 'required|exists:segunda_db.states,id',
        ]);

        try {
            // Encontrar la estación por su ID
            $estacion = Estacion::findOrFail($id);

            // Actualizar los datos de la estación
            $estacion->update([
                'num_estacion' => $validatedData['numestacion'],
                'razon_social' => $validatedData['razonsocial'],
                'rfc' => $validatedData['rfc'],
                'estado_id' => $validatedData['estado'],
            ]);

            // Redirigir con un mensaje de éxito
            return redirect()->route('estaciones.listar')->with('success', 'Estación actualizada exitosamente.');
        } catch (\Exception $e) {
            // Manejar errores y redirigir con un mensaje de error
            return redirect()->back()->with('error', 'Error al actualizar la estación: ' . $e->getMessage());
        }
    }


    private function obtenerEstacionesPorUsuario($usuario)
    {
        if ($usuario->hasAnyRole(['Administrador', 'Auditor'])) {
            $estaciones = Estacion::with('municipios')->get();
        } else {
            $estacionesDirectas = Estacion::where('usuario_id', $usuario->id)
                ->with('municipios') // Cargar los municipios relacionados
                ->get();
 
            $estacionesRelacionadas = Usuario_Estacion::where('usuario_id', $usuario->id)
                ->with(['estacion.municipios']) // Cargar los municipios de las estaciones relacionadas
                ->get()
                ->pluck('estacion');

            $estaciones = $estacionesDirectas->merge($estacionesRelacionadas)->unique('id');
        }

        // Para cada estación, obtener los municipios basados en el estado_id
        foreach ($estaciones as $estacion) {
            $estacion->municipios = Municipios::where('id_state', $estacion->estado_id)->get();
        }

        return $estaciones;
    }
}
