<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JuegosOnline extends Model
{
    use HasFactory;

    protected $table = 'juegos_online';

    protected $fillable = [
        'nombre',
        'categoria_id',
        'descripcion',
        'pagina_juego',
        'estado',
        'membresia_requerida',
    ];

    public function categoriaJuego(): BelongsTo
    {
        return $this->belongsTo(CategoriasJuego::class, 'categoria_id');
    }
    public function membresiaRequerida(): BelongsTo
    {
        return $this->belongsTo(Membresia::class, 'membresia_requerida');
    }
}
