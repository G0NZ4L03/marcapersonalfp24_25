<?php

namespace App\Http\Controllers;

use App\Models\Curriculo;
use Illuminate\Routing\Controllers\Middleware;

class CurriculoController extends Controller
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }
    public function getIndex()
    {
        return view('curriculos.index')
            ->with('curriculos', Curriculo::all());
    }

    public function getShow($id)
    {
        return view('curriculos.show')
            ->with('curriculo', Curriculo::findOrFail($id))
            ->with('id', $id);
    }

    public function getCreate()
    {
        return view('curriculos.create');
    }

    public function getEdit($id)
    {
        return view('curriculos.edit')
            ->with('curriculo', Curriculo::findOrFail($id))
            ->with('id', $id);
    }
}
