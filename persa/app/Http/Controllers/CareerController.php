<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::all();
        return response()->json($careers);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'type' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $career = Career::create($request->all());
        return response()->json($career, 201);
    }

    public function show($id)
    {
        $career = Career::findOrFail($id);
        return response()->json($career);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',  
            'type' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $career = Career::findOrFail($id);
        $career->update($request->all());
        return response()->json($career);
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);
        $career->delete();
        return response()->json(null, 204);
    }
}
