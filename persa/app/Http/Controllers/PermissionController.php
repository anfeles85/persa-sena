<?php

namespace App\Http\Controllers;

use App\Mail\MailAblePermissionNotifi;
use App\Mail\MailAblePermissionAcepted;
use App\Mail\MailAblePermissionCancel;
use App\Mail\MailAblePermissionDeclined;
use App\Mail\MailAblePermissionDeparture;
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
        'permission_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'reasons' => 'required|string|min:3|max:60',
        'location_id' => 'required|numeric|min:1',
        'permission_type_id' => 'required|numeric|min:1',
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

        //permisos ordenados por fecha más reciente
        $query = Permission::with([
            'apprentice_user.courses.career',
            'instructor_user',
            'guard_user',
            'location',
            'permissionType'
        ])
            ->orderBy('permission_date', 'desc')
            ->orderBy('start_time', 'desc')
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
        } elseif ($roleId == 4) {
            // Guarda ve todos los permisos de sedes con guardia (todos los estados)
            $query->whereHas('location', function ($q) {
                $q->where('guard', 'SI');
            });
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
        $courses = Course::with('career:id,name')
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
        return view('permission.create', compact('locations', 'permissionTypes'));
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

        $apprenticeId = auth()->id();

        // TODO: Validar que el aprendiz no tenga un permiso activo (PENDIENTE, APROBADO o TERMINADO) para la misma fecha
         $existingPermission = Permission::where('apprentice_id', $apprenticeId)
             ->where('permission_date', $request->permission_date)
             ->whereIn('status', ['PENDIENTE', 'APROBADO', 'TERMINADO'])
             ->first();

         if ($existingPermission) {
             return redirect()
                 ->route('permission.create')
                 ->withInput()
                 ->with('error', 'Ya tienes un permiso en proceso');
         }

        $data = $request->only([
            'permission_date',
            'start_time',
            'end_time',
            'reasons',
            'location_id',
            'permission_type_id',
        ]);

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
        if (Auth::user()->role_id == 3 && $permission->status !== 'PENDIENTE') {
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

        if ($validator->fails()) {
            return redirect()
                ->route('permission.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $apprenticeId = auth()->id();

        // TODO: Validar que no tenga otro permiso activo para la misma fecha (excepto el que está editando)
        // $existingPermission = Permission::where('apprentice_id', $apprenticeId)
        //     ->where('permission_date', $request->permission_date)
        //     ->where('id', '!=', $id) // Excluir el permiso actual
        //     ->whereIn('status', ['PENDIENTE', 'APROBADO', 'TERMINADO'])
        //     ->first();

        // if ($existingPermission) {
        //     return redirect()
        //         ->route('permission.edit', $id)
        //         ->withInput()
        //         ->withErrors(['permission_date' => 'Ya tienes otro permiso activo para esta fecha. Debes cancelarlo primero.']);
        // }

        $data = $request->only([
            'permission_date',
            'start_time',
            'end_time',
            'reasons',
            'location_id',
            'permission_type_id',
        ]);

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

        $permission->update($data);

        return redirect()->route('permission.index')->with('success', 'El permiso se editó correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        if (Auth::user()->role_id == 3 && $permission->status !== 'PENDIENTE') {
            return redirect()->route('permission.index')
                ->with('warning', 'Solo puedes eliminar permisos que estén en estado PENDIENTE.');
        }

        $permission->delete();

        return redirect()->route('permission.index')
            ->with('success', 'Permiso eliminado correctamente');
    }

    public function approve(Request $request, Permission $permission){
    $permission->load(['location', 'apprentice_user']);

    if ($permission->location->guard == 'SI') { 
        $permission->status = 'APROBADO';
        $permission->save();
        // No enviar email aún, se enviará cuando el guarda registre la salida
        
        return redirect()->back()->with('success', 'Permiso aprobado. Pendiente de registro de salida por parte del guarda.');
    } else {
        $permission->status = 'TERMINADO';
        $permission->departure_time = now()->format('H:i:s');
        $permission->save();

        
        // Enviar email de aprobación al aprendiz (sedes sin guardia)
        if ($permission->apprentice_user && $permission->apprentice_user->email) {
            Mail::to($permission->apprentice_user->email)
                ->send(new MailAblePermissionAcepted($permission));
        }
        
        return redirect()->back()->with('success', 'El permiso ha sido aprobado y la salida registrada.');
    }
}

public function registerDeparture(Request $request, Permission $permission)
{
    $permission->load([
        'location',
        'permissionType', 
        'apprentice_user.courses.career', 
    ]);

    if ($permission->location->guard == 'SI' && $permission->status == 'APROBADO') {

        $permission->departure_time = now()->format('H:i:s');
        $permission->status = 'TERMINADO';
        $permission->save();

        // Enviar email de salida registrada al aprendiz
        if ($permission->apprentice_user && $permission->apprentice_user->role_id == 3) {

            $apprentice = $permission->apprentice_user;
            $course = $permission->apprentice_user->courses->first();
            
           Mail::to($apprentice->email)
                ->send(new MailAblePermissionDeparture($permission, $apprentice, $course));
        }

        return redirect()->back()->with('success', 'La hora de salida ha sido registrada.');
    }

    return redirect()->back()->with('warning', 'No es posible registrar la salida. El permiso no está aprobado o la sede no tiene guardia.');
}

    public function reject(Request $request, Permission $permission)
    {
        $permission->status = 'RECHAZADO';
        $permission->save();

        if ($permission->apprentice_user && $permission->apprentice_user->email) {
            Mail::to($permission->apprentice_user->email)->send(new MailAblePermissionDeclined($permission, $request));
        }

        return redirect()->back()->with('success', 'El permiso ha sido rechazado y se ha notificado al aprendiz.');
    }

    public function cancel(Request $request, Permission $permission)
    {
        // Validar que solo el aprendiz pueda cancelar su propio permiso
        if (Auth::user()->role_id != 3 || $permission->apprentice_id != Auth::id()) {
            return redirect()->back()->with('warning', 'Solo el aprendiz puede cancelar su propia solicitud.');
        }

        $permission->status = 'CANCELADO';
        $permission->save();

        if ($permission->apprentice_user && $permission->apprentice_user->email) {
            Mail::to($permission->apprentice_user->email)->send(new MailAblePermissionCancel($permission));
        }

        return redirect()->back()->with('success', 'Has cancelado tu solicitud de permiso.');
    }

    public function terminate(Request $request, Permission $permission)
    {
        $permission->status = 'TERMINADO';
        $permission->save();

        return redirect()->back()->with('success', 'El permiso ha sido terminado correctamente');
    }

    public function notify(Request $request, Permission $permission)
    {
        $permission->load(['apprentice_user', 'permissionType', 'location']);
        if ($permission->apprentice_user && $permission->apprentice_user->email) {
            Mail::to($permission->apprentice_user->email)->send(new MailAblePermissionNotifi($permission));
        }

        return redirect()->back()->with('success', 'Se ha registrado la salida del aprendiz');
    }
}
