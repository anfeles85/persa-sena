<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public $traductionAttributes = [
        'password' => 'contraseña',
        'current_password' => 'contraseña actual',
        'password_confirmation' => 'confirmación de contraseña',
    ];

    public function index()
    {
        return view('auth.change_password');
    }

    public function changePassword(Request $request)
    {
         $request->validate([
            'current_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ], [], $this->traductionAttributes);

        // Asegurarnos que hay un usuario autenticado
        if (!auth()->check()) {
            return redirect()->route('auth.login')->with('warning', 'Debes iniciar sesión para cambiar la contraseña');
        }

        $user = User::find(auth()->id());

        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'Usuario no encontrado');
        }

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta');
        }

        // Evitar que la nueva contraseña sea igual a la actual
        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'La nueva contraseña no puede ser igual a la contraseña actual');
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Contraseña cambiada exitosamente');
    }
}