<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CourseProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        // Honeypot anti-bots: campo oculto que un humano nunca rellena. Si viene con algo, se descarta.
        if (filled($request->input('website'))) {
            return back()->withInput($request->except(['password', 'password_confirmation']));
        }

        // reCAPTCHA v2 (si está configurado en .env). Si no, se usa la casilla "not_robot".
        $usaRecaptcha = (bool) config('services.recaptcha.secret_key');
        if ($usaRecaptcha) {
            $ok = false;
            try {
                $resp = Http::asForm()->timeout(8)->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => config('services.recaptcha.secret_key'),
                    'response' => $request->input('g-recaptcha-response'),
                    'remoteip' => $request->ip(),
                ]);
                $ok = (bool) ($resp->json('success') ?? false);
            } catch (\Throwable $e) {
                $ok = false;
            }
            if (! $ok) {
                return back()->withInput($request->except(['password', 'password_confirmation']))
                    ->withErrors(['g-recaptcha-response' => 'No pudimos verificar que no eres un robot. Marca la casilla e inténtalo de nuevo.']);
            }
        }

        $rules = [
            // 1. Datos personales
            'name'             => ['required', 'string', 'max:255'],
            'last_name'        => ['required', 'string', 'max:255'],
            'document_id'      => ['required', 'string', 'max:50'],
            // 'email:rfc' + regex: exige dominio con punto y TLD (rechaza "prueba@ejemplo").
            'email'            => ['required', 'email:rfc', 'regex:/^[^@\s]+@[^@\s]+\.[A-Za-z]{2,}$/', 'max:255', 'confirmed', 'unique:users,email'],
            'password'         => ['required', 'confirmed', Password::min(8)],
            // 2. Datos profesionales
            'specialty'        => ['required', 'string', 'max:150'],
            // Si eligen "Otra", deben escribir su especialidad (esta NO tiene acreditación oficial).
            'specialty_other'  => ['nullable', 'required_if:specialty,Otra', 'string', 'max:150'],
            // 3. Perfil profesional
            'experience_level' => ['required', 'in:0-7,8-15,16+'],
            // Consentimiento
            'accepted_privacy' => ['accepted'],
        ];
        // Solo exigir la casilla "No soy un robot" cuando NO hay reCAPTCHA.
        if (! $usaRecaptcha) {
            $rules['not_robot'] = ['accepted'];
        }

        $data = $request->validate($rules, [
            'accepted_privacy.accepted'   => 'Debes aceptar la política de privacidad y el aviso legal.',
            'not_robot.accepted'          => 'Confirma que no eres un robot.',
            'email.email'                 => 'Introduce un correo electrónico válido.',
            'email.regex'                 => 'El correo debe incluir un dominio válido (p. ej. nombre@dominio.com).',
            'email.confirmed'             => 'Los correos electrónicos no coinciden.',
            'password.confirmed'          => 'Las contraseñas no coinciden.',
            'password.min'                => 'La contraseña debe tener al menos 8 caracteres.',
            'specialty_other.required_if' => 'Escribe tu especialidad.',
            'experience_level.required'   => 'Debes seleccionar tu perfil profesional.',
            'experience_level.in'         => 'Selecciona un perfil profesional válido.',
        ]);

        // Si la especialidad es "Otra", guardamos la que el usuario escribió (sin acreditación oficial).
        $specialty = $data['specialty'] === 'Otra'
            ? trim($data['specialty_other'])
            : $data['specialty'];

        $user = User::create([
            'name'              => $data['name'],
            'last_name'         => $data['last_name'],
            'document_id'       => $data['document_id'],
            'email'             => $data['email'],
            'password'          => $data['password'], // se hashea por el cast del modelo
            'specialty'         => $specialty,
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
