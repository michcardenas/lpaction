<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Inscrito autorizado a registrarse, cargado por Excel/CSV desde /admin.
 * Se combina con config/registrantes.php en App\Support\Registrantes.
 */
class AuthorizedRegistrant extends Model
{
    protected $fillable = ['email', 'document', 'name'];
}
