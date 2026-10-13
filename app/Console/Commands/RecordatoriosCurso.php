<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Lanza AUTOMÁTICAMENTE los recordatorios 05 (2 semanas antes del cierre) y 06 (48 h antes),
 * comparando la fecha de hoy con la fecha de cierre configurada (curso.correos.fecha_cierre_iso).
 *
 * Pensado para ejecutarse UNA VEZ AL DÍA por cron en Hostinger:
 *   0 8 * * *  /opt/alt/php82/usr/bin/php /ruta/al/proyecto/artisan correos:recordatorios
 *
 * Como se auto-evalúa por fecha, el cron no necesita ninguna lógica: cada día comprueba si
 * hoy es el día del recordatorio y, solo entonces, envía. El resto de días no hace nada.
 *
 * Opciones:
 *   --force   Ignora la comprobación de fecha y envía AMBOS recordatorios ahora (para pruebas).
 */
class RecordatoriosCurso extends Command
{
    protected $signature = 'correos:recordatorios {--force : Enviar ambos recordatorios ahora, sin comprobar la fecha}';

    protected $description = 'Envía los recordatorios 05 (2 semanas) y 06 (48 h) según la fecha de cierre del curso.';

    public function handle(): int
    {
        if ($this->option('force')) {
            $this->warn('Modo --force: enviando ambos recordatorios ahora (sin comprobar fecha).');
            $this->call('correos:enviar', ['plantilla' => '05-faltan-2-semanas']);
            $this->call('correos:enviar', ['plantilla' => '06-faltan-48h']);
            return self::SUCCESS;
        }

        $iso = config('curso.correos.fecha_cierre_iso');
        if (empty($iso)) {
            $this->comment('No hay fecha de cierre configurada (LPA_FECHA_CIERRE_ISO). No se envía nada.');
            return self::SUCCESS;
        }

        try {
            $cierre = Carbon::parse($iso);
        } catch (\Throwable $e) {
            $this->error("LPA_FECHA_CIERRE_ISO no es una fecha válida: {$iso}");
            Log::warning('correos:recordatorios · fecha de cierre inválida: ' . $iso);
            return self::FAILURE;
        }

        $hoy          = Carbon::today();
        $diaDosSemanas = $cierre->copy()->subWeeks(2)->startOfDay();
        $diaCuarentaY8 = $cierre->copy()->subDays(2)->startOfDay();

        $this->info('Cierre: ' . $cierre->toDateString()
            . ' · recordatorio 2 semanas: ' . $diaDosSemanas->toDateString()
            . ' · recordatorio 48 h: ' . $diaCuarentaY8->toDateString()
            . ' · hoy: ' . $hoy->toDateString());

        $enviado = false;

        if ($hoy->isSameDay($diaDosSemanas)) {
            $this->info('Hoy toca el recordatorio de 2 semanas → enviando 05.');
            $this->call('correos:enviar', ['plantilla' => '05-faltan-2-semanas']);
            Log::info('correos:recordatorios · enviado 05-faltan-2-semanas');
            $enviado = true;
        }

        if ($hoy->isSameDay($diaCuarentaY8)) {
            $this->info('Hoy toca el recordatorio de 48 h → enviando 06.');
            $this->call('correos:enviar', ['plantilla' => '06-faltan-48h']);
            Log::info('correos:recordatorios · enviado 06-faltan-48h');
            $enviado = true;
        }

        if (! $enviado) {
            $this->comment('Hoy no corresponde ningún recordatorio.');
        }

        return self::SUCCESS;
    }
}
