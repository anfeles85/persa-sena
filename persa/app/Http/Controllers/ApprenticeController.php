<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
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
        $user = Auth::user();
        
        
        if (method_exists($user, 'courses')) {
            $user->load('courses.career');
        }
        
        return view('user.profile', compact('user'));
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


    }
