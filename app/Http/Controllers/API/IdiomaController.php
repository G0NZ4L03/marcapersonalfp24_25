<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IdiomaResource;
use App\Models\Idiomas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IdiomaController extends Controller
{
    public $modelclass = Idiomas::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return IdiomaResource::collection(
            Idiomas::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
                ->paginate($request->perPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Añado las autorizaciones del middleware en el controlador (store, update y destroy)
        Gate::authorize('create', arguments: Idiomas::class);
        $idioma = json_decode($request->getContent(), true);
        //Creo una comprobacion para que el usuario que cree, pase a ser el propietario
        if ($idioma = Idiomas::create($idioma)) {
            $request->user()->esPropietario();
        } else {
            return response()->json([
                'message' => 'Error al crear la familia profesional'
            ], 400);
        }
        return new IdiomaResource($idioma);
    }

    /**
     * Display the specified resource.
     */
    public function show(Idiomas $idioma)
    {
        return new IdiomaResource($idioma);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Idiomas $idioma)
    {
        Gate::authorize('update', arguments: Idiomas::class);
        $cicloData = json_decode($request->getContent(), true);
        $idioma->update($cicloData);

        return new IdiomaResource($idioma);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idiomas $idioma)
    {
        Gate::authorize('delete', $idioma);
        try {
            $idioma->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
