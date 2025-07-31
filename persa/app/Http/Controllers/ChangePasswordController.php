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

        $user = User::where('email', 'dameon82@example.com')->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        //Permite comparar contraseñas sin tener que desencriptar
        $currentPasswordStatus = Hash::check($request->current_password, $user->password);

        if ($currentPasswordStatus) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Contraseña cambiada exitosamente');
        } else {
            return redirect()->back()->with('error', 'La contraseña actual no coincide con la contraseña antigua');
        }
    }
}