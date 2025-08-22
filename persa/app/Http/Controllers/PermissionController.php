<?php

namespace App\Http\Controllers;

use App\Mail\MailAblePermission;
use App\Mail\MailAblePermissionAcepted;
use App\Mail\MailAblePermissionCancel;
use App\Mail\MailAblePermissionDeclined;
use App\Models\Course;
use App\Models\Location;
use App\Models\Permission;
use App\Models\PermissionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

public function index(Request $request)
{
    $roleId = Auth::user()->role_id;

    $query = Permission::with([
            'apprentice_user.courses.career',
            'instructor_user',
            'guard_user',
            'location',
            'permissionType'
        ])
        ->orderBy('permission_date', 'desc')
        ->orderBy('id', 'desc');

    if ($roleId == 3) {
        // Aprendiz
        $query->where('apprentice_id', Auth::id());
    } elseif ($roleId == 2) {
        // Instructor → permisos solo de sus fichas
        $courseIds = DB::table('instructor_course')
            ->where('instructor_id', Auth::id())
            ->pluck('course_id');

        $apprenticeIds = DB::table('apprentice_course')
            ->whereIn('course_id', $courseIds)
            ->pluck('user_id');

        $query->whereIn('apprentice_id', $apprenticeIds);
    }

    // Filtrar por nombre o documento
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->whereHas('apprentice_user', function ($q) use ($search) {
            $q->where('fullname', 'LIKE', "%{$search}%")
              ->orWhere('document', 'LIKE', "%{$search}%");
        });
    }

    // Filtrar por estado
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    // Filtrar por ficha
   if ($request->filled('course_id')) {
    $courseId = $request->input('course_id');

    $query->whereHas('apprentice_user.courses', function ($q) use ($courseId) {
        $q->where('course.id', $courseId); 
    });
}

    $permissions = $query->get();
    $courses =Course::with('career:id,name')
        ->select('id', 'number_group', 'career_id')
        ->orderBy('number_group')
        ->get();

    return view('permission.index', compact('permissions', 'courses'));
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
        
        $apprenticeId = auth()->id();

        $courseId = DB::table('apprentice_course')
            ->where('user_id', $apprenticeId)
            ->value('course_id');

        $instructorId = DB::table('instructor_course')
            ->where('course_id', $courseId)
            ->value('instructor_id');

        $careerId = DB::table('course')
            ->where('id', $courseId)
            ->value('career_id');
        

        $data['instructor_id']  = $instructorId;
        $data['guard_id']       = 1;
        $data['status']         = 'PENDIENTE';
        $data['apprentice_id']  = $apprenticeId;
        $data['career_id'] = $careerId;

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
        // Validar: si es aprendiz y el permiso no está pendiente
        if(Auth::user()->role_id == 3 && $permission->status !== 'PENDIENTE') {
            return redirect()->route('permission.index')
            ->with('warning', 'Solo puedes editar permisos que estén en estado PENDIENTE.');
        }


        $locations = Location::all();
        $permissionTypes = PermissionType::all();

        return view('permission.edit', compact('permission', 'locations', 'permissionTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);

        // Validar: si es aprendiz y el permiso no está pendiente
        if (Auth::user()->role_id == 3 && $permission->status !== 'PENDIENTE') {
        return redirect()->route('permission.index')
            ->with('warning', 'No puedes modificar un permiso que ya fue aprobado, rechazado o cancelado.');
        }
        
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

        $apprenticeId = auth()->id();

        $courseId = DB::table('apprentice_course')
            ->where('user_id', $apprenticeId)
            ->value('course_id');

        $instructorId = DB::table('instructor_course')
            ->where('course_id', $courseId)
            ->value('instructor_id');

        $data['instructor_id']  = $instructorId;
        $data['guard_id']       = 1;
        $data['status']         = 'PENDIENTE';

        $data['apprentice_id']  = $apprenticeId;
        
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
    $permission = Permission::findOrFail($id);

    // Permite solo eliminar permisos que estén en estado PENDIENTE
    if (Auth::user()->role_id == 3 && $permission->status !== 'PENDIENTE') {
        return redirect()->route('permission.index')
            ->with('warning', 'Solo puedes eliminar permisos que estén en estado PENDIENTE.');
    }

    $permission->delete();

    return redirect()->route('permission.index')
        ->with('success', 'Permiso eliminado correctamente');
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
