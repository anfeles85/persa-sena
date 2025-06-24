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
            return redirect()->route('permission_type.create')->withInput()->withErrors($validator->errors());
        }

        $request->merge([
        'name' => strtoupper($request->name),
        ]); 

        PermissionType::create($request->all());
        return redirect()->route('permission_type.index')->with('created_successfully', true);
    }

    public function edit($id)
    {
       $permission_types = PermissionType::find($id);
        if ($permission_types) // si existe
        {
            return view('permission_type.edit', compact('permission_type'));
        }
        else
        {
            session()->flash('warning', 'No se encuentra el técnico solicitado');
            return redirect()->route('permission_type.index');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('permission_type.edit', $id)->withInput()->withErrors($errors);
        }
        $permission_types = PermissionType::find($id);
        if($permission_types) 
        {
            $permission_types->update($request->all());
            session()->flash('message', 'Actividad actualizada exitosamente');
        }
        else
        {
            session()->flash('warning', 'No se encuentra la actividad solicitado');
            return redirect()->route('permission_type.index');
        }

        return redirect()->route('permission_type.index')->with('success', 'El tipo de permiso se editó correctamente.');
    }

    public function destroy($id)
    {
        PermissionType::destroy($id); 
        return redirect()->route('permission_type.index')->with('success', 'Tipo de permiso eliminado correctamente');
    }
}