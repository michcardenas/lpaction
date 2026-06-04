<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseProgress extends Model
{
    protected $table = 'course_progress';

    protected $fillable = [
        'user_id',
        'module_key',
        'status',
        'percent',
        'completed_at',
    ];

    protected $casts = [
        'percent'      => 'integer',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Crea el progreso inicial del curso para un usuario (idempotente).
     * El primer ingreso queda disponible; el resto bloqueado.
     */
    public static function seedFor(User $user): void
    {
        $modules = ['ingreso-1', 'ingreso-2', 'ingreso-3', 'evaluacion', 'diploma'];

        foreach ($modules as $key) {
            $user->progress()->firstOrCreate(
                ['module_key' => $key],
                [
                    'status'  => $key === 'ingreso-1' ? 'available' : 'locked',
                    'percent' => 0,
                ]
            );
        }
    }
}
