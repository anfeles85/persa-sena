<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $rules = [
        'permission_date' => 'required|date|date_format:Y-m-d',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
        'departure_time' => 'required|date_format:H:i',
        'reasons' => 'required|string|min:3|max:60',
        'instructor_id' => 'required|numeric|min:1|max:99999999999999999999',
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
        'guard_id' => 'guarda id',
        'status' => 'estado',
        'location_id' => 'sede id',
        'permission_type_id' => 'tipo de permiso id',
    ];

    private $status = [
        ['name' => 'APROBADO', 'value' => 'APROBADO'],
        ['name' => 'PENDIENTE', 'value' => 'PENDIENTE'],
        ['name' => 'DESAPROBADO', 'value' => 'DESAPROBADO'],
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
