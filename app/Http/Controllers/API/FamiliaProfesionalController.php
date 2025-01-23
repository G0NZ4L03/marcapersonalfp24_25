<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ReactAdminResponse;
use App\Http\Resources\FamiliaProfesionalResource;
use App\Models\FamiliaProfesional;
use Illuminate\Http\Request;

class FamiliaProfesionalController extends Controller
{
    public $modelclass = FamiliaProfesional::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FamiliaProfesional::query();

        ReactAdminResponse::applyFilter($request,$query, filterColumns: ['codigo','nombre']);
        ReactAdminResponse::applySort($request, $query);

        return FamiliaProfesionalResource::collection(
            $query->paginate($request->perPage ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $familiaProfesional = json_decode($request->getContent(),true);

        $familiaProfesional = FamiliaProfesional::create($familiaProfesional);

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
        $familiaProfesionalData = json_decode($request->getContent(), true);
        $familiaProfesional->update($familiaProfesionalData);

        return new FamiliaProfesionalResource($familiaProfesional);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamiliaProfesional $familiaProfesional)
    {
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
