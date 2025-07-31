<?php

namespace App\Http\Controllers;

use App\Mail\MailAblePermission;
use App\Mail\MailAblePermissionAcepted;
use App\Mail\MailAblePermissionCancel;
use App\Mail\MailAblePermissionDeclined;
use App\Models\Location;
use App\Models\Permission;
use App\Models\PermissionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    private $rules = [
        'permission_date' => 'required|date|date_format:Y-m-d',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
        'reasons' => 'required|string|min:3|max:60', 
        'location_id' => 'required|numeric|min:1|max:99999999999999999999',
        'permission_type_id' => 'required|numeric|min:1|max:99999999999999999999',
    ];

    private $traductionAttributes = [
        'permission_date' => 'fecha de permiso',
        'start_time' => 'hora de inicio',
        'end_time' => 'hora de fin',
        'reasons' => 'motivo',
        'location_id' => 'sede',
        'permission_type_id' => 'tipo de permiso',
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
        return view('permission.create', compact('locations','permissionTypes'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
        return redirect()
            ->route('permission.create')
            ->withInput()
            ->withErrors($validator);
        }
        $data = $request->only([
            'permission_date',
            'start_time',
            'end_time',
            'reasons',
            'location_id',
            'permission_type_id',
        ]);

        $data['instructor_id']  = 1;          
        $data['guard_id']       = 1;
        $data['status']         = 'PENDIENTE'; 
        $data['departure_time'] = now()->format('H:i');
        $data['apprentice_id']  = 1;

        Permission::create($data);
        return redirect()->route('permission.index')->with('success', 'Permiso creado exitosamente');
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

        $data = $request->only([
        'permission_date',
        'start_time',
        'end_time',
        'reasons',
        'location_id',
        'permission_type_id',
    ]);
        $data['instructor_id']  = 1;          
        $data['guard_id']       = 1;
        $data['status']         = 'PENDIENTE'; 
        $data['departure_time'] = now()->format('H:i');
        $data['apprentice_id']  = 1;
        
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
    
    
    // Metodos para enviar correos
    public function approve(Request $request, Permission $permission)
    {
        $permission->status = 'APROBADO';
        $permission->save();

        Mail::to($permission->apprentice->email)->send(new MailAblePermissionAcepted($permission));

        return redirect()->back()-with('success', 'El permiso ha sido aprobado y se ha notificado al aprendiz.');

    }
    
    public function reject(Request $request, Permission $permission)
    {
        $permission->status = 'RECHAZADO';
        $permission->save();

        Mail::to($permission->apprentice->email)->send(new MailAblePermissionDeclined($permission, $request));
    
        return redirect()->back()->with('success', 'El permiso ha sido rechazado y se ha notificado al aprendiz.');
    }

    public function cancel(Request $request, Permission $permission)
    {
        $permission->status = 'CANCELADO';
        $permission->save();

        Mail::to($permission->apprentice->email)->send(new MailAblePermissionCancel($permission));

        return redirect()->back()->with('success', 'El permiso ha sido cancelado');
    }

    public function notify(Request $request, Permission $permission)
    {
        $permission->load(['apprentice', 'permissionType', 'location']);
        Mail::to($permission->apprentice->email)->send(new MailAblePermission($permission));

        return redirect()->back()->with('success', 'Se ha registrado la salida del aprendiz');
    }
}
