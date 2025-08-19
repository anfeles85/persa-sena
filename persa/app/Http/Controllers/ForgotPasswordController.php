<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * muestra formulario para recordar contraseña
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forget_password');
    }

    /**
     * recibe el contenido del form de recordar contraseña
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forget_password', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->route('auth.index')->with('success', 'Hemos enviado un correo con un enlace para recuperar tu contraseña');
    }

    /**
     * muestra el form de reset de contraseña
     */
    public function showResetPasswordForm($token) 
    { 
        return view('auth.forget_password_link', ['token' => $token]);
    }

    /**
     * recibe los datos del form de reset contraseña
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:password'
        ]);

        $updatePassword = DB::table('password_reset_tokens')->where([
                                                        'email' => $request->email, 
                                                        'token' => $request->token
                                                        ])->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Token Inválido!');
        }        

        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
        return redirect()->route('auth.index')->with('success', 'Tu contraseña se ha actualizado');
    }
}
