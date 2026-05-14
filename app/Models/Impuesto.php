<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    protected $fillable = ['nombre', 'porcentaje', 'activo', 'recordatorio_pago'];

    protected function casts(): array
    {
        return [
            'porcentaje' => 'decimal:2',
            'activo' => 'boolean',
            'recordatorio_pago' => 'date',
        ];
    }
}
