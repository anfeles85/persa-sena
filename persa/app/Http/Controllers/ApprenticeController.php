<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApprenticeController extends Controller
{
    private $rules = [  
        'document' => 'required|string|max:20|unique:users,document',
        'name' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'email_confirmation' => 'required|same:email',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|same:password',
        'course_id' => 'required|exists:course,id'
    ];

    private $traductionAttributes = [
        'document' => 'documento',
        'name' => 'nombres',
        'lastname' => 'apellidos',
        'email' => 'correo electrónico',
        'email_confirmation' => 'confirmar correo electrónico',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmar contraseña',
        'course_id' => 'ficha'
    ];

    public function index(Request $request)
    {
        $courses = Course::with('career')->where('status', 'ACTIVO')->get();
        
        $apprentices = null;
        if ($request->has('course_id') && $request->course_id) {
            $apprentices = DB::table('users')
                            ->join('apprentice_course', 'users.id', '=', 'apprentice_course.user_id')
                            ->join('course', 'apprentice_course.course_id', '=', 'course.id')
                            ->join('career', 'course.career_id', '=', 'career.id')
                            ->where('users.role_id', 3)
                            ->where('course.id', $request->course_id)
                            ->where('course.status', 'ACTIVO')
                            ->select(
                                'users.id',
                                'users.document',
                                'users.fullname',
                                'users.email',
                                'users.status',
                                'course.shift as course_shift',
                                'course.trimester as course_trimester',
                                'course.year as course_year',
                                'career.name as career_name'
                            )
                            ->get();
        }
        
        return view('apprentice.index', compact('courses', 'apprentices'));
    }

    public function create()
    {
        $courses = Course::with('career')->where('status', 'ACTIVO')->get();
        return view('auth.register', compact('courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('auth.register')
                             ->withInput()
                             ->withErrors($validator);
        }

        $user = User::create([
            'document' => $request->input('document'),
            'fullname' => strtoupper($request->input('name') . ' ' . $request->input('lastname')),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => 3,
            'status' => 'ACTIVO'
        ]);

        $user->courses()->attach($request->input('course_id'));

        session()->flash('success', 'Registro exitoso. Por favor inicia sesión.');
        return redirect()->route('auth.login');
    }

    public function edit()
    {
        $roles = Roles::all();
        $user = Auth::user();
        
        if (method_exists($user, 'courses')) {
            $user->load('courses.career');
        }
        
        return view('user.profile', compact('user','roles'));
    }


    public function showProfile($id)
    {

        if (Auth::user()->role_id != 1) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $apprentice = User::with(['courses.career'])->findOrFail($id);
        
        if ($apprentice->role_id != 3) {
            return redirect()->route('apprentice.index')->with('error', 'El usuario seleccionado no es un aprendiz.');
        }

        $courses = Course::with('career')->where('status', 'ACTIVO')->get();
        
        return view('apprentice.profile', compact('apprentice', 'courses'));
    }

    public function updateProfile(Request $request, $id)
    {
        if (Auth::user()->role_id != 1) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $apprentice = User::findOrFail($id);
        
        if ($apprentice->role_id != 3) {
            return redirect()->route('apprentice.index')->with('error', 'El usuario seleccionado no es un aprendiz.');
        }


        $updateRules = [
            'document' => 'required|string|max:20|unique:users,document,' . $id,
            'fullname' => 'required|string|max:500',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'course_id' => 'required|exists:course,id',
            'status' => 'required|in:ACTIVO,INACTIVO'
        ];

        $validator = Validator::make($request->all(), $updateRules);
        $validator->setAttributeNames([
            'document' => 'documento',
            'fullname' => 'nombre completo',
            'email' => 'correo electrónico',
            'course_id' => 'ficha',
            'status' => 'estado'
        ]);

        if ($validator->fails()) {
            return redirect()->route('apprentice.profile', $id)
                             ->withInput()
                             ->withErrors($validator);
        }

        $apprentice->update([
            'document' => $request->input('document'),
            'fullname' => strtoupper($request->input('fullname')),
            'email' => $request->input('email'),
            'status' => $request->input('status')
        ]);

        $apprentice->courses()->sync([$request->input('course_id')]);

        session()->flash('success', 'Perfil del aprendiz actualizado correctamente.');
        return redirect()->route('apprentice.profile', $id);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $updateRules = [
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];
        
        $validator = Validator::make($request->all(), $updateRules);
        $validator->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('user.profile')
                             ->withInput()
                             ->withErrors($validator);
        }

        $user->email = $request->input('email');
        $user->save();

        session()->flash('success', 'Perfil actualizado correctamente.');
        return redirect()->route('user.profile');
    }

    public function toggleStatus($id)
    {
        $user = Auth::user();
        
        if (!in_array($user->role_id, [1, 2])) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $apprentice = User::findOrFail($id);

        if ($apprentice->role_id != 3) {
            return redirect()->back()->with('error', 'Solo se puede cambiar el estado de aprendices.');
        }

        $newStatus = $apprentice->status == 'ACTIVO' ? 'INACTIVO' : 'ACTIVO';
        $apprentice->update(['status' => $newStatus]);

        $message = $newStatus == 'ACTIVO' ? 'Aprendiz activado correctamente.' : 'Aprendiz inactivado correctamente.';
        
        return redirect()->back()->with('success', $message);
    }
    
    public function destroy($id)
    {
        $apprentice = User::findOrFail($id);

        if ($apprentice->role_id != 3) {
            return redirect()->back()->with('error', 'Solo se pueden inhabilitar aprendices.');
        }

        $apprentice->update([
            'status' => 'INACTIVO'
        ]);

        return redirect()->route('apprentice.index')->with('success', 'Aprendiz inhabilitado correctamente.');
    }
}