<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = Roles::create($request->all());
        return response()->json($role, 201);
    }

    public function show($id)
    {
        $role = Roles::findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = Roles::findOrFail($id);
        $role->update($request->all());
        return response()->json($role);
    }

    public function destroy($id)
    {
        $role = Roles::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}