<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BilleteraCliente extends Model
{
    use HasFactory;

    protected $table = 'billetera_cliente';

    protected $fillable = [
        'cliente_id',
        'balance_real',
        'balance_bonus',
        'balance_pendiente',
        'total_depositado',
        'total_retirado',
        'total_ganado',
        'total_apostado',
        'moneda',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(UserCliente::class, 'cliente_id');
    }
}
