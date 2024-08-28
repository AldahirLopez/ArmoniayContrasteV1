<?php

namespace App\Http\Controllers;


use App\Models\Estacion;
use App\Http\Controllers\Controller;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; // Importa la clase Auth

class EstacionController extends Controller
{

    protected $connection = 'segunda_db';

    public function index()
    {
        return view('armonia.estaciones.index');
    }

    public function show()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Obtener la lista de estados (asumiendo que se necesita en la vista)
        $estados = Estados::where('id_country', 42)->get();

        // Inicializar la variable para almacenar las estaciones
        $estaciones = [];

        if ($usuario->hasAnyRole(['Administrador', 'Auditor'])) {
            // Mostrar todas las estaciones si el usuario es administrador o auditor
            $estaciones = Estacion::all();
        } else {
            $estacionesDirectas = Estacion::where('usuario_id', $usuario->id)->get();
            // Inicializar una colección para las estaciones relacionadas
            $estacionesRelacionadas = collect();

            // Verificar si el usuario no es administrador para buscar relaciones
            if (!$usuario->hasAnyRole(['Administrador', 'Auditor'])) {
                // Obtener las relaciones de usuario a estación
                $relaciones = Usuario_Estacion::where('usuario_id', $usuario->id)->get();

                // Recorrer las relaciones para obtener las estaciones relacionadas
                foreach ($relaciones as $relacion) {
                    // Obtener la estación relacionada y añadirla a la colección
                    $estacionRelacionada = Estacion::find($relacion->estacion_id);
                    if ($estacionRelacionada) {
                        $estacionesRelacionadas->push($estacionRelacionada);
                    }
                }
            }
            // Combinar estaciones directas y relacionadas y eliminar duplicados
            $estaciones = $estacionesDirectas->merge($estacionesRelacionadas)->unique('id');
        }

        // Pasar los datos a la vista
        return view('armonia.estaciones.listar', compact('usuario', 'estados', 'estaciones'));
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'numestacion' => 'required|unique:segunda_db.estacion,num_estacion|max:10',
            'razonsocial' => 'required|string|max:255',
            'rfc' => 'required|string|',
            'estado' => 'required',
        ]);

        try {
            // Obtener el ID del usuario autenticado
            $idUsuario = auth()->user()->id; // Obtener el ID del usuario logueado

            // Crear una nueva estación
            Estacion::create([
                'num_estacion' => $request->input('numestacion'),
                'razon_social' => $request->input('razonsocial'),
                'rfc' => $request->input('rfc'),
                'estado_id' => $request->input('estado'),
                'id_usuario' => $idUsuario, // Usar el ID del usuario autenticado
            ]);

            // Redirigir con mensaje de éxito
            return redirect()->route('estaciones.listar')->with('success', 'Estación creada exitosamente.');
        } catch (\Exception $e) {
            // Manejar errores y redirigir con mensaje de error
            return redirect()->back()->with('error', 'Error al crear la estación: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Buscar la estación por su ID y eliminarla
            $estacion = Estacion::findOrFail($id);
            $estacion->delete();

            // Redirigir con mensaje de éxito
            return redirect()->route('estaciones.index')->with('success', 'Estación eliminada exitosamente.');
        } catch (\Exception $e) {
            // Manejar errores y redirigir con mensaje de error
            return redirect()->route('estaciones.index')->with('error', 'Error al eliminar la estación: ' . $e->getMessage());
        }
    }
}
