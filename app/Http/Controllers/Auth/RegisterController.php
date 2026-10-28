<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CorreoPlantilla;
use App\Models\CourseProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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

        // Inscritos AUTORIZADOS a registrarse (config/registrantes.php): mapa correo => documento.
        // SOLO estas personas pueden crear cuenta, identificándose por CORREO + DOCUMENTO (ambos
        // deben coincidir). Si la lista está vacía, el registro queda abierto a todos.
        $autorizados = config('registrantes.autorizados', []);

        $rules = [
            // 1. Datos personales
            'name'             => ['required', 'string', 'max:255'],
            'last_name'        => ['required', 'string', 'max:255'],
            'document_id'      => ['required', 'string', 'max:50'],
            // 'email:rfc' + regex: exige dominio con punto y TLD (rechaza "prueba@ejemplo").
            // Además: solo se permiten correos de la lista blanca de inscripción (si hay lista).
            // Sin 'unique': una cuenta PRE-CARGADA (semilla is_test=true) se puede reclamar al
            // registrarse. El bloqueo de re-registro de cuentas YA reales se hace en el after().
            'email'            => ['required', 'email:rfc', 'regex:/^[^@\s]+@[^@\s]+\.[A-Za-z]{2,}$/', 'max:255', 'confirmed'],
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

        $messages = [
            'accepted_privacy.accepted'   => 'Debes aceptar la política de privacidad y el aviso legal.',
            'email.email'                 => 'Introduce un correo electrónico válido.',
            'email.regex'                 => 'El correo debe incluir un dominio válido (p. ej. nombre@dominio.com).',
            'email.confirmed'             => 'Los correos electrónicos no coinciden.',
            'email.unique'                => 'Este correo electrónico ya está registrado. Si ya tienes una cuenta, inicia sesión.',
            'password.confirmed'          => 'Las contraseñas no coinciden.',
            'password.min'                => 'La contraseña debe tener al menos 8 caracteres.',
            'specialty_other.required_if' => 'Escribe tu especialidad.',
            'experience_level.required'   => 'Debes seleccionar tu perfil profesional.',
            'experience_level.in'         => 'Selecciona un perfil profesional válido.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // RESTRICCIÓN DE INSCRIPCIÓN: solo pueden registrarse las personas de la lista de autorizados,
        // identificadas por CORREO + DOCUMENTO (ambos deben coincidir con el mismo registro).
        $validator->after(function ($v) use ($request, $autorizados) {
            // No se puede volver a registrar un correo que YA tiene cuenta REAL (is_test=false).
            // Las cuentas PRE-CARGADAS de prueba (is_test=true) SÍ se pueden reclamar al registrarse.
            $existente = User::where('email', $request->input('email'))->first();
            if ($existente && ! $existente->is_test) {
                $v->errors()->add('email', 'Este correo electrónico ya está registrado. Si ya tienes una cuenta, inicia sesión.');
            }
            if (empty($autorizados)) {
                return; // lista vacía = registro abierto
            }
            $email = strtolower(trim((string) $request->input('email')));
            if (! array_key_exists($email, $autorizados)) {
                $v->errors()->add('email', 'Este correo no está en la lista de inscritos autorizados. Si crees que es un error, contacta con la organización.');
                return;
            }
            // El correo está autorizado: el documento debe coincidir con el de ese registro.
            $docAutorizado = $autorizados[$email];
            if ($docAutorizado !== '') {
                $docIngresado = $this->normalizarDoc($request->input('document_id'));
                if ($docIngresado === '' || $docIngresado !== $docAutorizado) {
                    $v->errors()->add('document_id', 'El documento de identificación no coincide con el del correo autorizado.');
                }
            }
        });

        $data = $validator->validate();

        // Si la especialidad es "Otra", guardamos la que el usuario escribió (sin acreditación oficial).
        $specialty = $data['specialty'] === 'Otra'
            ? trim($data['specialty_other'])
            : $data['specialty'];

        // Si el correo ya existía PRE-CARGADO (semilla is_test=true), se RECLAMA esa cuenta: pasa a
        // registrada (is_test=false) con los datos que la persona rellena en el formulario. Si no
        // existía, se crea nueva. (Las cuentas reales ya se rechazaron en la validación.)
        $existente = User::where('email', $data['email'])->first();
        $user = $existente ?: new User();
        $user->fill([
            'name'              => $data['name'],
            'last_name'         => $data['last_name'],
            'document_id'       => $data['document_id'],
            'email'             => $data['email'],
            'password'          => $data['password'], // se hashea por el cast del modelo
            'specialty'         => $specialty,
            'experience_level'  => $data['experience_level'],
            'accepted_privacy'  => true,
        ]);
        $user->is_test = false;                       // al registrarse queda identificado como REAL
        if (! $existente) $user->accepted_novartis = false;
        $user->save();

        // Progreso inicial del curso: ingreso 1 disponible, resto bloqueado.
        CourseProgress::seedFor($user);

        Auth::login($user);

        // Correo de bienvenida (plantilla 01). Un fallo de SMTP no debe impedir el alta: se registra
        // en el log y el usuario continúa igualmente.
        try {
            Mail::to($user->email)->send(new CorreoPlantilla(
                '01-bienvenida',
                'Tu inscripción en Lp(a)ction está confirmada',
                ['nombre' => $user->name, 'cta_url' => url('/login')],
            ));
        } catch (\Throwable $e) {
            Log::warning('No se pudo enviar el correo de bienvenida a ' . $user->email . ': ' . $e->getMessage());
        }

        // Tras registrarse se muestra el POP-UP DE BIENVENIDA (petición del cliente): se vuelve al
        // login con el overlay; el alumno entra al curso solo al pulsar "Entrar al curso" (que marca
        // welcome_seen). La ruta GET /login no tiene middleware guest, así que el overlay se renderiza
        // aunque el usuario ya esté autenticado.
        return redirect()->route('login')->with('bienvenida', true);
    }

    /** Normaliza un documento para comparar: MAYÚSCULAS y solo caracteres alfanuméricos
     *  (quita espacios, puntos y guiones). Igual que la normalización de config/registrantes.php. */
    private function normalizarDoc($doc): string
    {
        return preg_replace('/[^A-Z0-9]/', '', strtoupper(trim((string) $doc)));
    }
}
