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
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }

        Roles::create($request->all());
        session()->flash('message', 'Rol creado exitosamente');
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $role = Roles::find($id);
        if ($role) {
            return view('roles.edit', compact('role'));
        }

        session()->flash('warning', 'Rol no encontrado');
        return redirect()->route('roles.index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }

        $role = Roles::find($id);
        if ($role) {
            $role->update($request->all());
            session()->flash('message', 'Rol actualizado exitosamente');
        } else {
            session()->flash('warning', 'Rol no encontrado');
        }

        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $role = Roles::find($id);
        if ($role) {
            $role->delete();
            session()->flash('message', 'Rol eliminado exitosamente');
        } else {
            session()->flash('warning', 'Rol no encontrado');
        }

        return redirect()->route('roles.index');
    }
}