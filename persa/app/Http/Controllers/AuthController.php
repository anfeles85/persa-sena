<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|max:255|min:8',
        'password_confirmation' => 'required|same:password',
        'g-recaptcha-response' => 'required|captcha'
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmar contraseña',
        'g-recaptcha-response' => 'captcha'
    ];

    public function index()
    {
        return view('auth.login');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('name', 'email', 'password', 'password_confirmation'), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('auth.register')->withInput()->withErrors($errors);
        }

        $data = $request->only('name', 'email', 'password');
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        session()->flash('message', 'Registro creado exitosamente');
        return redirect()->route('auth.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ], [], $this->traductionAttributes);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->status == 'INACTIVO') {
                Auth::logout();
                return redirect()->route('auth.index')->with('message', 'Tu cuenta está inactiva. Contacta al administrador.');
            }

            $request->session()->regenerate();
            return redirect()->route('index');
        }

        return redirect()->route('auth.index')->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.index');
    }
}