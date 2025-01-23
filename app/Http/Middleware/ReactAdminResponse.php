<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReactAdminResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->merge(['perPage' => 10]);
        if($request->filled('_start')) {
            if($request->filled('_end')) {
                $request->merge(['perPage' => intval($request->_end - $request->_start)+1]);
            }
            $request->merge(['page' => intval($request->_start / $request->perPage) + 1]);
        }
        $response = $next($request);
        if($request->routeIs('*.index')) {
            abort_unless(property_exists($request->route()->controller, 'modelclass'), 500, "It must exists a modelclass property in the controller.");
            $modelClassName = $request->route()->controller->modelclass;
            $response->header('X-Total-Count',$modelClassName::count());
        }
        try {
            if(is_callable([$response, 'getData'])) {
                $responseData = $response->getData();
                if(isset($responseData->data)) {
                    $response->setData($responseData->data);
                }
            }
        } catch (\Throwable $th) { }
        return $response;

}
public static function applyFilter(Request $request, $query, array $filterColumns)
{
    if ($request->filled('q')) {
        $search = $request->input('q');
        $query->where(function ($query) use ($filterColumns, $search) {
            foreach ($filterColumns as $column) {
                $query->orWhere($column, 'like', '%' . $search . '%');
            }
        });
    } else {
        foreach ($filterColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, 'like', '%' . $request->input($column) . '%');
            }
        }
    }
}

public static function applySort(Request $request, $query)
{
    if ($request->filled('_sort') && $request->filled('_order')) {
        $query->orderBy($request->_sort, $request->_order);
    }
}
}
