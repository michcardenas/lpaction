<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CourseProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /** Mostrar el formulario de registro */
    public function show()
    {
        return view('auth.register');
    }

    /** Procesar el registro */
    public function store(Request $request)
    {
        $data = $request->validate([
            // 1. Datos personales
            'name'             => ['required', 'string', 'max:255'],
            'last_name'        => ['required', 'string', 'max:255'],
            'document_id'      => ['required', 'string', 'max:50'],
            'email'            => ['required', 'email', 'max:255', 'confirmed', 'unique:users,email'],
            'password'         => ['required', 'confirmed', Password::min(8)],
            // 2. Datos profesionales
            'specialty'        => ['required', 'string', 'max:150'],
            // 3. Perfil profesional
            'experience_level' => ['required', 'in:0-7,8-15,16+'],
            // Consentimiento
            'accepted_privacy' => ['accepted'],
        ], [
            'accepted_privacy.accepted' => 'Debes aceptar la política de privacidad y el aviso legal.',
            'email.confirmed'           => 'Los correos electrónicos no coinciden.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'name'              => $data['name'],
            'last_name'         => $data['last_name'],
            'document_id'       => $data['document_id'],
            'email'             => $data['email'],
            'password'          => $data['password'], // se hashea por el cast del modelo
            'specialty'         => $data['specialty'],
            'experience_level'  => $data['experience_level'],
            'accepted_privacy'  => true,
            'accepted_novartis' => false,
        ]);

        // Progreso inicial del curso: ingreso 1 disponible, resto bloqueado.
        CourseProgress::seedFor($user);

        Auth::login($user);

        // Entra directo al curso "La evolución de Juan".
        return redirect()->route('curso')->with('status', '¡Registro completado! Bienvenido/a, ' . $user->name . '.');
    }
}
