<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PerfilController extends Controller
{
    /** Página "Mi cuenta" con los datos del usuario autenticado. */
    public function show()
    {
        return view('perfil', ['user' => Auth::user()]);
    }

    /** Cambiar la contraseña del usuario autenticado. */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required'         => 'Indica tu contraseña actual.',
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.required'                 => 'Indica la nueva contraseña.',
            'password.confirmed'                => 'Las contraseñas nuevas no coinciden.',
            'password.min'                      => 'La nueva contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = Auth::user();
        $user->password = $request->input('password'); // el cast "hashed" del modelo la cifra
        $user->save();

        return redirect()->route('perfil')->with('perfil_status', 'Tu contraseña se actualizó correctamente.');
    }
}
