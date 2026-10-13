<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Correo HTML basado en las plantillas tokenizadas de resources/mail/*.html.
 *
 * Cada plantilla trae imágenes alojadas por URL (no base64, para no disparar el
 * "clipping" de Gmail) y tokens que se sustituyen aquí:
 *   {{IMG_*}}        -> URL absoluta de public/images/mail/*
 *   {{NOMBRE}}       -> nombre del destinatario
 *   {{CTA_URL}}      -> destino del botón de acción
 *   {{FECHA_CIERRE}} -> solo plantillas 05 y 06
 */
class CorreoPlantilla extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param string $plantilla  nombre del fichero sin extensión (p.ej. '01-bienvenida')
     * @param string $asunto     asunto del correo
     * @param array  $vars       ['nombre' => ..., 'cta_url' => ..., 'fecha_cierre' => ...]
     */
    public function __construct(
        public string $plantilla,
        public string $asunto,
        public array $vars = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('curso.correos.from_address', 'no-reply@lpaction.es'),
                config('curso.correos.from_name', 'Lp(a)ction'),
            ),
            subject: $this->asunto,
        );
    }

    public function content(): Content
    {
        return new Content(htmlString: static::construirHtml($this->plantilla, $this->vars));
    }

    /**
     * Renderiza una plantilla sustituyendo los tokens. Público y estático para poder
     * reutilizarlo en la vista previa del admin sin construir el Mailable completo.
     * (No se llama render() porque Mailable ya define un render() no estático.)
     */
    public static function construirHtml(string $plantilla, array $vars = []): string
    {
        $ruta = resource_path('mail/' . $plantilla . '.html');
        if (! is_file($ruta)) {
            abort(404, 'Plantilla de correo no encontrada: ' . $plantilla);
        }
        $html = file_get_contents($ruta);

        $nombre = trim((string) ($vars['nombre'] ?? ''));
        if ($nombre === '') {
            $nombre = 'participante';
        }

        $sust = [
            '{{IMG_LPACTION}}'   => asset('images/mail/lpaction-logo.png'),
            '{{IMG_SEC}}'        => asset('images/mail/sec-logo.png'),
            '{{IMG_LIPO}}'       => asset('images/mail/lipoproteina.png'),
            '{{IMG_SEC_FOOTER}}' => asset('images/mail/sec-footer.png'),
            '{{IMG_NOVARTIS}}'   => asset('images/mail/novartis.png'),
            '{{IMG_QUALIMED}}'   => asset('images/mail/qualimed.png'),
            '{{NOMBRE}}'         => e($nombre),
            '{{CTA_URL}}'        => $vars['cta_url'] ?? url('/login'),
            '{{FECHA_CIERRE}}'   => e($vars['fecha_cierre'] ?? config('curso.correos.fecha_cierre', '')),
        ];

        return strtr($html, $sust);
    }
}
