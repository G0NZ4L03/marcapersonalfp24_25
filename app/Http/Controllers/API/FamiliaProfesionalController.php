<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamiliaProfesionalResource;
use App\Models\FamiliaProfesional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FamiliaProfesionalController extends Controller
{
    public $modelclass = FamiliaProfesional::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->attributes->has('queryWithParameters')
            ? $request->attributes->get('queryWithParameters')
            : FamiliaProfesional::query();
        return FamiliaProfesionalResource::collection($query->paginate($request->perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Añado las autorizaciones del middleware en el controlador (store, update y destroy)
        Gate::authorize('create', FamiliaProfesional::class);
        $familiaProfesional = json_decode($request->getContent(),true);
        //Creo una comprobacion para que el usuario que cree, pase a ser el propietario
        if ($familiaProfesional = FamiliaProfesional::create($familiaProfesional)) {
            $request->user()->esPropietario();
        } else {
            return response()->json([
                'message' => 'Error al crear la familia profesional'
            ], 400);
        }

        return new FamiliaProfesionalResource(($familiaProfesional));
    }

    /**
     * Display the specified resource.
     */
    public function show(FamiliaProfesional $familiaProfesional)
    {
        return new FamiliaProfesionalResource($familiaProfesional);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FamiliaProfesional $familiaProfesional)
    {
        Gate::authorize('update', $familiaProfesional);

        $familiaProfesionalData = json_decode($request->getContent(), true);
        $familiaProfesional->update($familiaProfesionalData);

        return new FamiliaProfesionalResource($familiaProfesional);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamiliaProfesional $familiaProfesional)
    {
        Gate::authorize('delete', $familiaProfesional);
        try {
            $familiaProfesional->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
