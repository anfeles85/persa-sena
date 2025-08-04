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

        $user = User::where('email', 'lebsack.elton@example.org')->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'La contraseña es incorrecta');
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'La nueva contraseña no puede ser igual a la contraseña actual');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Contraseña cambiada exitosamente');
    }
}