<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return UsersResource::collection(
            Users::orderBy($request->_sort ?? 'id', $request->_order ?? 'asc')
            ->paginate($request->perPage));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users = json_decode($request->getContent(), true);

        $users = Users::create($users);

        return new UsersResource($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
            return new UsersResource($users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        $usersData = json_decode($request->getContent(), true);
        $users->update($usersData);

        return new usersResource($users);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        try {
            $users->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
