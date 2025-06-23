<?php

namespace App\Http\Controllers;

use App\Models\PermissionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionTypeController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:255',
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
    ];

    public function index()
    {
        $permissionTypes = PermissionType::all();
        return view('permission_type.index', compact('permissionTypes'));
    }

    public function create()
    {
        $permissionTypes = PermissionType::all();
        return view('permission_type.create', compact('permissionTypes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('permission_type.create')->withInput()->withErrors($validator);
        }

        $request->merge([
        'name' => strtoupper($request->name),
        ]); 

        PermissionType::create($request->all());
        return redirect()->route('permission_type.index')->with('created_successfully', true);
    }

    public function edit($id)
    {
       return redirect()->back()->with('success', 'Tipo de permiso editado correctamente.');
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        PermissionType::destroy($id); 
        return redirect()->route('permission_type.index')->with('success', 'Tipo de permiso eliminado correctamente');
    }
}