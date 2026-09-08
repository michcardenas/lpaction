<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'document_id',
        'country',
        'province',
        'city',
        'email',
        'password',
        'specialty',
        'hospital',
        'center_type',
        'experience_level',
        'accepted_privacy',
        'accepted_novartis',
        'is_admin',
        'is_test',
        'cert_icomem',
        'welcome_seen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'accepted_privacy' => 'boolean',
            'accepted_novartis' => 'boolean',
            'is_admin' => 'boolean',
            'is_test' => 'boolean',
            'cert_icomem' => 'boolean',
            'welcome_seen' => 'boolean',
        ];
    }

    /** Progreso del curso (un registro por módulo). */
    public function progress(): HasMany
    {
        return $this->hasMany(CourseProgress::class);
    }

    /** ¿Es administrador del panel? */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * ¿Debe verse el pop-up de bienvenida? Solo si NO lo ha visto todavía (welcome_seen=false)
     * y aún no ha empezado ningún ingreso (todo en 0%). Se usa tras el login/registro.
     */
    public function needsWelcome(): bool
    {
        if ($this->welcome_seen) {
            return false;
        }
        $progress = $this->progress()->get()->keyBy('module_key');
        foreach (array_column(config('curso.ingresos', []), 'key') as $k) {
            $p = $progress->get($k);
            if ($p && (in_array($p->status, ['in_progress', 'completed'], true) || (int) ($p->etapa_index ?? 0) > 0)) {
                return false;
            }
        }
        return true;
    }
}
