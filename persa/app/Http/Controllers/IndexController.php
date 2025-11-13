<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Permission;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        // Sólo el coordinador puede ver este dashboard; otros son redirigidos
        if (auth()->user()->role_id != 1) {
            return redirect()->route('permission.index');
        }

        $careers = Career::all();
    $permissions = Permission::all();
    $totalUsers = User::count();
    $pendingPermissions = Permission::where('status', 'PENDIENTE')->count();
    $todaysPendingPermissions = Permission::where('status', 'PENDIENTE')
        ->whereDate('permission_date', now()->toDateString())
        ->count();

    // Aprendices activos 
    $apprenticeActives = User::where('role_id', 3)
        ->whereIn('status', ['ACTIVO', 'ACTIVE'])
        ->count();

    $users = User::all();
    $groupsCount = Course::count();

        $quantityOfpermissionPerson = Permission::selectRaw('users.fullname as nombre, COUNT(*) as cantidad')
            ->join('users', 'permission.apprentice_id', '=', 'users.id')
            ->where('users.role_id', 3)
            ->whereIn('users.status', ['ACTIVO', 'ACTIVE'])
            ->groupBy('users.fullname')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get()
            ->pluck('cantidad', 'nombre');

        $quantityOfpermissionLocation = Permission::selectRaw('location.name as lugar, COUNT(*) as cantidad')
            ->join('location', 'permission.location_id', '=', 'location.id')
            ->groupBy('location.name')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get()
            ->pluck('cantidad', 'lugar');

        $quantityOfpermissionStatus = Permission::selectRaw('status as estado, COUNT(*) as cantidad')
            ->groupBy('estado')
            ->orderByDesc('cantidad')
            ->get()
            ->pluck('cantidad', 'estado');

        // Contar permisos por curso/grupo
        $quantityOfpermissionCourse = Permission::selectRaw('course.number_group as curso, COUNT(permission.id) as cantidad')
            ->join('users', 'permission.apprentice_id', '=', 'users.id')
            ->join('apprentice_course', 'users.id', '=', 'apprentice_course.user_id')
            ->join('course', 'apprentice_course.course_id', '=', 'course.id')
            ->where('users.role_id', 3)
            ->whereIn('users.status', ['ACTIVO', 'ACTIVE'])
            ->groupBy('course.number_group')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get()
            ->pluck('cantidad', 'curso');

        // Reutilizamos el resultado para el gráfico por grupo
        $quantityOfpermissionGroup = $quantityOfpermissionCourse;

        return view('index', compact(
            'careers',
            'permissions',
            'pendingPermissions',
            'todaysPendingPermissions',
            'totalUsers',
            'apprenticeActives',
            'users',
            'quantityOfpermissionCourse',
            'groupsCount',
            'quantityOfpermissionGroup',
            'quantityOfpermissionPerson',
            'quantityOfpermissionLocation',
            'quantityOfpermissionStatus'
        ));
    }
}