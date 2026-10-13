<?php

namespace App\Console\Commands;

use App\Mail\CorreoPlantilla;
use App\Models\CourseProgress;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Envío masivo de los correos de difusión / recordatorio (03, 04, 05, 06).
 *
 *   php artisan correos:enviar 04-modulo3              → difunde el módulo 3 a todos los alumnos
 *   php artisan correos:enviar 03-completa-curso       → recuerda a quienes no han terminado
 *   php artisan correos:enviar 05-faltan-2-semanas     → recordatorio 2 semanas antes del cierre
 *   php artisan correos:enviar 06-faltan-48h           → recordatorio 48 h antes del cierre
 *   php artisan correos:enviar 04-modulo3 --dry        → solo lista destinatarios, no envía
 *
 * Los correos 01 (bienvenida) y 02 (recuperación) son transaccionales: se envían solos y no
 * se usan aquí.
 */
class EnviarCorreoCurso extends Command
{
    protected $signature = 'correos:enviar
                            {plantilla : 03-completa-curso | 04-modulo3 | 05-faltan-2-semanas | 06-faltan-48h}
                            {--dry : Solo listar destinatarios, sin enviar}';

    protected $description = 'Envía un correo de difusión/recordatorio del curso a los alumnos correspondientes.';

    /** Asunto de cada plantilla. */
    private const ASUNTOS = [
        '03-completa-curso'   => 'Te esperamos para que completes el curso',
        '04-modulo3'          => '¡Ya está disponible el módulo 3!',
        '05-faltan-2-semanas' => 'Faltan 2 semanas para finalizar Lp(a)ction',
        '06-faltan-48h'       => 'Faltan 48 horas para finalizar Lp(a)ction',
    ];

    public function handle(): int
    {
        $plantilla = $this->argument('plantilla');

        if (! isset(self::ASUNTOS[$plantilla])) {
            $this->error('Plantilla no válida. Usa una de: ' . implode(', ', array_keys(self::ASUNTOS)));
            return self::FAILURE;
        }
        if (! is_file(resource_path('mail/' . $plantilla . '.html'))) {
            $this->error("No existe la plantilla resources/mail/{$plantilla}.html");
            return self::FAILURE;
        }

        $asunto       = self::ASUNTOS[$plantilla];
        $fechaCierre  = config('curso.correos.fecha_cierre');
        $soloPendientes = $plantilla !== '04-modulo3'; // 04 va a todos; el resto solo a quien no terminó.

        $destinatarios = $this->destinatarios($soloPendientes);

        $this->info("Plantilla: {$plantilla}");
        $this->info("Asunto:    {$asunto}");
        $this->info('Criterio:  ' . ($soloPendientes ? 'alumnos que NO han finalizado (no APTO)' : 'todos los alumnos activos'));
        $this->info('Destinatarios: ' . $destinatarios->count());

        if ($this->option('dry')) {
            foreach ($destinatarios as $u) {
                $this->line("  - {$u->email}  ({$u->name})");
            }
            $this->comment('Modo --dry: no se ha enviado ningún correo.');
            return self::SUCCESS;
        }

        $enviados = 0;
        $fallos   = 0;
        foreach ($destinatarios as $u) {
            try {
                Mail::to($u->email)->send(new CorreoPlantilla($plantilla, $asunto, [
                    'nombre'       => $u->name,
                    'cta_url'      => url('/login'),
                    'fecha_cierre' => $fechaCierre,
                ]));
                $enviados++;
            } catch (\Throwable $e) {
                $fallos++;
                Log::warning("Fallo al enviar {$plantilla} a {$u->email}: " . $e->getMessage());
                $this->warn("  ✗ {$u->email}: " . $e->getMessage());
            }
        }

        $this->info("Enviados: {$enviados}" . ($fallos ? "  ·  Fallos: {$fallos}" : ''));
        return self::SUCCESS;
    }

    /**
     * Alumnos destinatarios: usuarios reales (no admin, no cuentas de prueba).
     * Si $soloPendientes, excluye a quienes ya han aprobado la evaluación (APTO).
     *
     * @return \Illuminate\Support\Collection<int,\App\Models\User>
     */
    private function destinatarios(bool $soloPendientes)
    {
        $alumnos = User::where('is_admin', false)->where('is_test', false)->get();

        if (! $soloPendientes) {
            return $alumnos;
        }

        $aptos = CourseProgress::where('module_key', 'evaluacion')
            ->whereIn('user_id', $alumnos->pluck('id'))
            ->get()
            ->filter(fn ($p) => ! empty(($p->etapas ?? [])['apto']))
            ->pluck('user_id')
            ->all();

        return $alumnos->reject(fn ($u) => in_array($u->id, $aptos, true))->values();
    }
}
