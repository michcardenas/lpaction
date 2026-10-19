<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TutoriaController extends Controller
{
    /** Muestra la página de tutoría (formulario de contacto). */
    public function show()
    {
        return view('tutoria');
    }

    /** Procesa el formulario de contacto y envía el mensaje al buzón de gestión. */
    public function send(Request $request)
    {
        $data = $request->validate(
            ['motivo' => ['required', 'string', 'min:5', 'max:5000']],
            [
                'motivo.required' => 'Escribe tu motivo de contacto.',
                'motivo.min'      => 'El mensaje es demasiado corto.',
                'motivo.max'      => 'El mensaje es demasiado largo.',
            ]
        );

        $user       = Auth::user();
        $nombre     = trim(($user->name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Usuario';
        $emailUser  = $user->email ?? null;
        $destino    = config('curso.correos.tutoria_to', 'gestion@qualimed.es');
        $fromAddr   = config('curso.correos.from_address', 'no-reply@lpaction.es');
        $fromName   = config('curso.correos.from_name', 'Lp(a)ction');

        $cuerpo = nl2br(e($data['motivo']));
        $html = <<<HTML
<div style="font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#1f2933;line-height:1.6">
  <h2 style="color:#0b7285;margin:0 0 16px">Nuevo mensaje de tutoría</h2>
  <p style="margin:0 0 6px"><strong>Nombre:</strong> {$nombre}</p>
  <p style="margin:0 0 6px"><strong>Correo:</strong> {$emailUser}</p>
  <hr style="border:none;border-top:1px solid #e3e8ee;margin:16px 0">
  <p style="margin:0 0 8px"><strong>Motivo de contacto:</strong></p>
  <div style="background:#f5f7fa;border-radius:8px;padding:14px 16px">{$cuerpo}</div>
  <p style="margin:20px 0 0;font-size:12px;color:#8a9199">Enviado desde el formulario de Tutoría de Lp(a)ction.</p>
</div>
HTML;

        try {
            Mail::html($html, function ($message) use ($destino, $fromAddr, $fromName, $nombre, $emailUser) {
                $message->to($destino)
                    ->from($fromAddr, $fromName)
                    ->subject('Tutoría Lp(a)ction — mensaje de ' . $nombre);
                if ($emailUser) {
                    $message->replyTo($emailUser, $nombre);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Fallo al enviar el formulario de tutoría', ['error' => $e->getMessage()]);

            return back()->withInput()->with('tut_error',
                'No se pudo enviar el mensaje en este momento. Inténtalo de nuevo en unos minutos.');
        }

        return back()->with('tut_success', 'Mensaje enviado con éxito. Te responderemos lo antes posible.');
    }
}
