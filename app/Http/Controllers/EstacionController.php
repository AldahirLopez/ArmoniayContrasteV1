<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
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

        // Obtener estaciones según el rol del usuario
        $estaciones = $this->obtenerEstacionesPorUsuario($usuario);

        return view('armonia.estaciones.listar-estaciones.listar', compact('usuario', 'estados', 'estaciones'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numestacion' => 'required|unique:segunda_db.estacion,num_estacion|max:10',
            'razonsocial' => 'required|string|max:255',
            'rfc' => 'required|string',
            'estado' => 'required|exists:segunda_db.states,id',
        ]);

        try {
            $idUsuario = Auth::id();

            Estacion::create([
                'num_estacion' => $validatedData['numestacion'],
                'razon_social' => $validatedData['razonsocial'],
                'rfc' => $validatedData['rfc'],
                'estado_id' => $validatedData['estado'],
                'usuario_id' => $idUsuario,
            ]);

            return redirect()->route('estaciones.listar')->with('success', 'Estación creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la estación: ' . $e->getMessage());
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
            return Estacion::all();
        }

        $estacionesDirectas = Estacion::where('usuario_id', $usuario->id)->get();

        $estacionesRelacionadas = Usuario_Estacion::where('usuario_id', $usuario->id)
            ->with('estacion') // Usa el método with() para optimizar la consulta
            ->get()
            ->pluck('estacion');

        return $estacionesDirectas->merge($estacionesRelacionadas)->unique('id');
    }
}
