<?php

namespace App\Http\Controllers;

use App\Models\PermissionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionTypeController extends Controller
{
    public function index()
    {
        $permissionTypes = PermissionType::all();
        return response()->json($permissionTypes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $permissionType = PermissionType::create($request->all());
        return response()->json($permissionType, 201);
    }

    public function show($id)
    {
        $permissionType = PermissionType::findOrFail($id);
        return response()->json($permissionType);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $permissionType = PermissionType::findOrFail($id);
        $permissionType->update($request->all());
        return response()->json($permissionType);
    }

    public function destroy($id)
    {
        $permissionType = PermissionType::findOrFail($id);
        $permissionType->delete();
        return response()->json(null, 204);
    }
}
