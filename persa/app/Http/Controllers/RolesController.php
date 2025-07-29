<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:50',
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
    ];

    public function index()
    {
        $roles = Roles::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $roles = Roles::all();
        return view('roles.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }

         $request->merge([
        'name' => strtoupper($request->name),
        ]); 

        Roles::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');
    }

    public function edit($id)
    {
       return redirect()->back()->with('success', 'El rol fue editado correctamente.');
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($id)
    {
        
        Roles::destroy($id); 
        return redirect()->route('roles.index')->with('success', 'Rol eliminada correctamente');
    }
}