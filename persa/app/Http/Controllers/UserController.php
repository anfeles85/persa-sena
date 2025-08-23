<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private $rules = [
        'fullname' => 'required|string|min:3|max:255',
        'email' => 'required|email|max:255',
        'document' => 'required|numeric',
        'password' => 'nullable|string|min:6|max:255|confirmed',
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

    public function indexApprentice()
    {
        $users = User::with(['role', 'apprenticeCourses.career'])
            ->whereHas('role', fn($q) => $q->where('name', 'APRENDIZ'))
            ->get();

        $viewMode = 'aprendices';
        return view('user.index', compact('users', 'viewMode'));
    }

    public function indexInstructors()
    {
        $users = User::with(['role', 'instructorCourses.career'])
            ->whereHas('role', fn($q) => $q->where('name', 'INSTRUCTOR'))
            ->get();

        $viewMode = 'instructores';
        return view('user.index', compact('users', 'viewMode'));
    }

    public function indexGuard(){
        $users = User::with(['role'])
            ->whereHas('role', fn($q) => $q->where('name', 'GUARDA'))
            ->get();

        $viewMode = 'guardas';
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
        $user = User::with(['role', 'apprenticeCourses.career'])->find($id);
        if (!$user) {
            session()->flash('warning', 'No se encuentra el usuario solicitado');
            return redirect()->route('user.index');
        }

        $roles = Roles::all();
        $statuses = $this->statuses;

        $courseModel = new Course();
        $courseTable = $courseModel->getTable();
        $courses = collect();
        $coursesAvailable = false;

        if (Schema::hasTable($courseTable)) {
            $coursesAvailable = true;

            if (optional($user->role)->name === 'APRENDIZ') {
                if ($user->apprenticeCourses->isNotEmpty()) {
                    $currentCourse = $user->apprenticeCourses->first();
                    $courses = Course::with('career')
                        ->where('career_id', $currentCourse->career_id)
                        ->get();
                } else {
                    $courses = Course::with('career')->get();
                }
            }
        }

        return view('user.edit', compact('user', 'roles', 'statuses', 'courses', 'coursesAvailable'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::with('role', 'apprenticeCourses.career')->find($id);
        if (!$user) {
            session()->flash('warning', 'No se encuentra el usuario solicitado');
            return redirect()->route('user.index');
        }

        $rules = $this->rules;

        $courseModel = new Course();
        $courseTable = $courseModel->getTable();

        $courseRule = ['nullable', 'integer'];
        if (Schema::hasTable($courseTable)) {
            $courseRule[] = Rule::exists($courseTable, 'id');
        }
        $rules['course_id'] = $courseRule;

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames(array_merge($this->traductionAttributes, [
            'course_id' => 'ficha',
        ]));

        $validator->after(function ($v) use ($request) {
            $role = Roles::find($request->input('role_id'));
            if ($role && strtoupper($role->name) === 'APRENDIZ' && !$request->filled('course_id')) {
                $v->errors()->add('course_id', 'La ficha es obligatoria para aprendices.');
            }
        });

        if ($validator->fails()) {
            return redirect()->route('user.edit', $id)->withInput()->withErrors($validator);
        }

        $data = $request->only(['fullname', 'email', 'document', 'password', 'status', 'role_id']);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        DB::transaction(function () use ($user, $data, $request, $courseTable) {
            $user->update($data);

            if (optional($user->role)->name === 'APRENDIZ') {
                if (Schema::hasTable($courseTable) && $request->filled('course_id')) {
                    $user->apprenticeCourses()->sync([$request->integer('course_id')]);
                } elseif (Schema::hasTable($courseTable)) {
                    $user->apprenticeCourses()->sync([]);
                }
            } else {
                if (Schema::hasTable('apprentice_course')) {
                    $user->apprenticeCourses()->detach();
                }
            }
        });

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