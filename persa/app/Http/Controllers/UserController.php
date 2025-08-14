<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $rules = [
        'fullname' => 'required|string|min:3|max:255',
        'email' => 'required|email|max:255',
        'document' => 'required|numeric',
        'password' => 'nullable|string|min:6|max:255',
        'status' => 'required|string|in:ACTIVO,INACTIVO',
        'role_id' => 'required|numeric|exists:roles,id'
    ];

    private $traductionAttributes = [
        'fullname' => 'nombre completo',
        'email' => 'correo electrónico',
        'document' => 'documento',
        'password' => 'contraseña',
        'status' => 'estado',
        'role_id' => 'rol'
    ];

    private $statuses = [
        ['name' => 'ACTIVO', 'value' => 'ACTIVO'],
        ['name' => 'INACTIVO', 'value' => 'INACTIVO']
    ];

    public function index()
    {
        $users = User::with(['role'])->get();
        $viewMode = 'todos';
        return view('user.index', compact('users', 'viewMode'));
    }

    public function indexAprendices()
    {
        $users = User::with(['role', 'apprenticeCourses.career'])
            ->whereHas('role', fn($q) => $q->where('name', 'APRENDIZ'))
            ->get();

        $viewMode = 'aprendices';
        return view('user.index', compact('users', 'viewMode'));
    }

    public function indexInstructores()
    {
        $users = User::with(['role', 'instructorCourses.career'])
            ->whereHas('role', fn($q) => $q->where('name', 'INSTRUCTOR'))
            ->get();

        $viewMode = 'instructores';
        return view('user.index', compact('users', 'viewMode'));
    }

    public function create()
    {
        $roles = Roles::all();
        $statuses = $this->statuses;
        return view('user.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('user.create')->withInput()->withErrors($validator);
        }

        $data = $request->all();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $roles = Roles::all();
            $statuses = $this->statuses;
            return view('user.edit', compact('user', 'roles', 'statuses'));
        }

        session()->flash('warning', 'No se encuentra el usuario solicitado');
        return redirect()->route('user.index');
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('user.edit', $id)->withInput()->withErrors($validator);
        }

        $user = User::find($id);
        if (!$user) {
            session()->flash('warning', 'No se encuentra el usuario solicitado');
            return redirect()->route('user.index');
        }

        $data = $request->all();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Usuario eliminado correctamente');
        }

        return redirect()->route('user.index')->with('warning', 'Usuario no encontrado');
    }
}