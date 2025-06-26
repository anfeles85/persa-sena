<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Permission;
use App\Models\PermissionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    private $rules = [
        'permission_date' => 'required|date|date_format:Y-m-d',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
        'departure_time' => 'required|date_format:H:i',
        'reasons' => 'required|string|min:3|max:60',
        'instructor_id' => 'required|numeric|min:1|max:99999999999999999999',
        'apprentice_id' => 'required|numeric|min:1|max:99999999999999999999',
        'guard_id' => 'required|numeric|min:1|max:99999999999999999999',
        'status' => 'required|string|min:3|max:50',
        'location_id' => 'required|numeric|min:1|max:99999999999999999999',
        'permission_type_id' => 'required|numeric|min:1|max:99999999999999999999'
    ];

    private $traductionAttributes = [
        'permission_date' => 'fecha de permiso',
        'start_time' => 'hora de inicio',
        'end_time' => 'hora de fin',
        'departure_time' => 'hora de salida',
        'reasons' => 'motivo',
        'instructor_id' => 'instructor id',
        'apprentice_id' => 'aprendiz id',
        'guard_id' => 'guarda id',
        'status' => 'estado',
        'location_id' => 'sede id',
        'permission_type_id' => 'tipo de permiso id',
    ];

    
    public function index()
    {
        $permissions = Permission::all();
        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        $locations = Location::all();
        $permissionTypes = PermissionType::all();
        return view('permission.create', compact('locations', 'permissionTypes',));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('permission.create')->withInput()->withErrors($validator->errors());
        }

        Permission::create($request->all());
        return redirect()->route('permission.index')->with('created_successfully', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::find($id);
        if ($permission) // si existe
        {
            $locations = Location::all();
            $permissionTypes = PermissionType::all();
            return view('permission.edit', compact('permission', 'locations', 'permissionTypes'));
        }
        else
        {
            session()->flash('warning', 'No se encuentra el técnico solicitado');
            return redirect()->route('permission.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('permission.edit', $id)->withInput()->withErrors($errors);
        }
        $permission = Permission::find($id);
        if($permission) 
        {
            $permission->update($request->all());
            session()->flash('message', 'Permiso actualizado exitosamente');
        }
        else
        {
            session()->flash('warning', 'No se encuentra el permiso solicitado');
            return redirect()->route('permission.index');
        }

        return redirect()->route('permission.index')->with('success', 'El permiso se editó correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Permission::destroy($id); 
        return redirect()->route('permission.index')->with('success', 'Permiso eliminado correctamente');
    }
}
