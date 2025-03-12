<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserCliente extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'nombre_completo',
        'documento_identidad',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'preferencias',
        'estado_cuenta',
        'fecha_suspension',
        'limite_deposito_diario',
        'limite_apuesta_diario',
        'email',
        'password',
    ];

    public function membresia(): BelongsTo
    {
        return $this->belongsTo(Membresia::class, 'membresia_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferencias' => 'array',
    ];


    /**
     * Create a billetera when a user_cliente is created
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($userCliente) {
            BilleteraCliente::create([
                'cliente_id' => $userCliente->id,
            ]);
        });
    }
    
}
