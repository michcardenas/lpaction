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
}
