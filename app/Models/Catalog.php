<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Catálogo configurable usado por formularios y filtros.
 *
 * El campo type agrupa valores como escolaridad, municipios o estados de
 * postulación; parent_id permite catálogos jerárquicos si el municipio los requiere.
 */
class Catalog extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'parent_id', 'name', 'code', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /**
     * Catálogo padre para agrupaciones jerárquicas.
     */
    public function parent() { return $this->belongsTo(Catalog::class, 'parent_id'); }

    /**
     * Valores hijos del catálogo actual.
     */
    public function children() { return $this->hasMany(Catalog::class, 'parent_id'); }

    /**
     * Limita consultas a valores activos para selects y filtros de captura.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
