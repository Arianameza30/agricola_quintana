<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Campos que pueden guardarse masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * Campos ocultos al convertir el modelo a arreglo o JSON.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión automática de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Recorridos creados por el usuario.
     */
    public function recorridos()
    {
        return $this->hasMany(Recorrido::class);
    }

    /**
     * Indica si el usuario es administrador.
     */
    public function esAdministrador(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * Indica si el usuario es un usuario final.
     */
    public function esUsuario(): bool
    {
        return $this->rol === 'usuario';
    }
}