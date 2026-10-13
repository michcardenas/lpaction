<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

/**
 * Flujo de recuperación de contraseña (olvidé / restablecer).
 * Usa el broker de contraseñas de Laravel; el correo con el enlace lo envía
 * User::sendPasswordResetNotification() con la plantilla 02.
 */
class PasswordResetController extends Controller
{
    /** Formulario "¿Olvidaste tu contraseña?" */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /** Enviar el enlace de restablecimiento. */
    public function sendResetLink(Request $request)
    {
        $request->validate(
            ['email' => ['required', 'email']],
            ['email.required' => 'Introduce tu correo electrónico.', 'email.email' => 'Introduce un correo electrónico válido.'],
        );

        // Respuesta neutra: no revelamos si el correo existe o no (privacidad).
        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Si el correo está registrado, te hemos enviado un enlace para restablecer tu contraseña. Revisa tu bandeja de entrada (y la carpeta de spam).');
    }

    /** Formulario para fijar la nueva contraseña (desde el enlace del correo). */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /** Guardar la nueva contraseña. */
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ], [
            'email.required'     => 'Introduce tu correo electrónico.',
            'email.email'        => 'Introduce un correo electrónico válido.',
            'password.required'  => 'Introduce la nueva contraseña.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => $password, // se hashea por el cast del modelo
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Tu contraseña se ha actualizado. Ya puedes iniciar sesión.');
        }

        $mensajes = [
            Password::INVALID_TOKEN => 'El enlace de restablecimiento no es válido o ha caducado. Solicita uno nuevo.',
            Password::INVALID_USER  => 'No encontramos una cuenta con ese correo electrónico.',
        ];

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => $mensajes[$status] ?? 'No se pudo restablecer la contraseña. Inténtalo de nuevo.']);
    }
}
