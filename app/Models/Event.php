<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Evento público administrado desde el dashboard institucional.
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'event_date', 'location', 'link', 'image_path', 'status', 'published_at', 'created_by', 'updated_by'];

    protected function casts(): array
    {
        return ['status' => EventStatus::class, 'event_date' => 'datetime', 'published_at' => 'datetime'];
    }

    /**
     * Usuario que creó el evento.
     */
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

    /**
     * Último usuario que actualizó el evento.
     */
    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }

    /**
     * Limita consultas públicas a eventos publicados.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', EventStatus::Published)->whereNotNull('published_at');
    }
}
