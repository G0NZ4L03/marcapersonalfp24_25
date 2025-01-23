<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ReactAdminResponse;
use App\Http\Resources\ReconocimientoResource;
use App\Models\Reconocimiento;
use Illuminate\Http\Request;

class ReconocimientoController extends Controller
{
    public $modelclass = Reconocimiento::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reconocimiento::query();

        ReactAdminResponse::applyFilter($request, $query,filterColumns: ['nombre', 'docente_validador']);
        ReactAdminResponse::applySort($request, $query);

        return ReconocimientoResource::collection(
            $query->paginate($request->perPage ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Reconocimiento = json_decode($request->getContent(), true);

        $Reconocimiento = Reconocimiento::create($Reconocimiento);

        return new ReconocimientoResource($Reconocimiento);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reconocimiento $Reconocimiento)
    {
        return new ReconocimientoResource($Reconocimiento);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reconocimiento $Reconocimiento)
    {
        $ReconocimientoData = json_decode($request->getContent(), true);
        $Reconocimiento->update($ReconocimientoData);

        return new ReconocimientoResource($Reconocimiento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reconocimiento $Reconocimiento)
    {
        try {
            $Reconocimiento->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
