<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        // Solo el coordinador (role_id = 1) ve el dashboard
        // Los demás roles van directo a permisos
        if (auth()->user()->role_id != 1) {
            return redirect()->route('permission.index');
        }

        $careers = Career::all();
        $permissions = Permission::all();
        $users =  User::all();

        $quantityOfpermissionPerson = Permission::selectRaw('users.fullname as nombre, COUNT(*) as cantidad')
            ->join('users', 'permission.instructor_id', '=', 'users.id')
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

        return view('index', compact(
            'careers',
            'permissions',
            'users',
            'quantityOfpermissionPerson',
            'quantityOfpermissionLocation',
            'quantityOfpermissionStatus'
        ));
    }
}