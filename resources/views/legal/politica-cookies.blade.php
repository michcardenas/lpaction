@extends('legal.base')

@section('titulo', 'Política de cookies')

@section('contenido')
<h1>Política de cookies</h1>
<p class="lg-sub">Información sobre el uso de cookies en lpaction.es</p>

<h2>¿Qué es una cookie?</h2>
<p>Una cookie es un pequeño fichero de texto que un sitio web almacena en el navegador del usuario cuando lo visita. Las cookies permiten, entre otras cosas, mantener la sesión iniciada y garantizar el funcionamiento seguro del servicio.</p>

<h2>¿Qué cookies utiliza esta web?</h2>
<p>El sitio <strong>lpaction.es</strong> utiliza <strong>únicamente cookies técnicas (estrictamente necesarias) y propias</strong>, imprescindibles para el funcionamiento de la plataforma y el acceso al área privada. <strong>No se utilizan cookies de análisis, de publicidad, de redes sociales ni de elaboración de perfiles</strong>, ni se ceden datos a terceros a través de cookies.</p>

<table style="width:100%; border-collapse:collapse; margin:10px 0 22px; font-size:14px;">
    <thead>
        <tr style="background:#eef4f7; text-align:left;">
            <th style="padding:10px 12px; border:1px solid #d6e0e5;">Cookie</th>
            <th style="padding:10px 12px; border:1px solid #d6e0e5;">Tipo</th>
            <th style="padding:10px 12px; border:1px solid #d6e0e5;">Finalidad</th>
            <th style="padding:10px 12px; border:1px solid #d6e0e5;">Duración</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;"><code>lpaction-session</code></td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Técnica propia</td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Mantener la sesión del usuario y el estado de navegación en el área privada.</td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Sesión (2 horas)</td>
        </tr>
        <tr>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;"><code>XSRF-TOKEN</code></td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Técnica propia (seguridad)</td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Proteger los formularios frente a ataques de falsificación de petición (CSRF).</td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Sesión (2 horas)</td>
        </tr>
        <tr>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;"><code>remember_web_*</code></td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Técnica propia</td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Recordar la sesión iniciada. Solo se crea si el usuario marca la casilla "Recordar usuario y contraseña".</td>
            <td style="padding:10px 12px; border:1px solid #d6e0e5;">Persistente (hasta cerrar sesión)</td>
        </tr>
    </tbody>
</table>

<p>Dado que todas las cookies empleadas son estrictamente necesarias para la prestación del servicio expresamente solicitado por el usuario, <strong>están exentas del deber de obtener consentimiento previo</strong>, de acuerdo con el artículo 22.2 de la Ley 34/2002 (LSSI) y las directrices de la Agencia Española de Protección de Datos.</p>

<h2>Fuentes externas sin cookies</h2>
<p>La web carga tipografías desde Google Fonts para su correcta visualización. Este servicio no instala cookies, aunque implica una conexión a los servidores de Google para la descarga de las fuentes.</p>

<h2>¿Cómo gestionar o desactivar las cookies?</h2>
<p>El usuario puede permitir, bloquear o eliminar las cookies instaladas en su equipo configurando las opciones del navegador que utilice. Puede consultar cómo hacerlo en la ayuda de los principales navegadores:</p>
<ul>
    <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">Google Chrome</a></li>
    <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener">Mozilla Firefox</a></li>
    <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener">Safari</a></li>
    <li><a href="https://support.microsoft.com/es-es/microsoft-edge" target="_blank" rel="noopener">Microsoft Edge</a></li>
</ul>
<p>Le informamos de que, al tratarse de cookies estrictamente necesarias, <strong>su desactivación impedirá el inicio de sesión y el uso correcto del área privada</strong> de la plataforma.</p>

<h2>Actualización</h2>
<p>Esta política de cookies puede ser actualizada en función de cambios técnicos o legislativos. Se recomienda consultarla periódicamente.</p>
@endsection
