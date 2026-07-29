<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
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
     * Campos que pueden guardarse masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'activo',
    ];

    /**
     * Campos ocultos al serializar el usuario.
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
            'activo' => 'boolean',
        ];
    }

    /**
     * Recorridos creados por el usuario.
     */
    public function recorridos(): HasMany
    {
        return $this->hasMany(Recorrido::class);
    }

    /**
     * Envía la notificación personalizada
     * para restablecer la contraseña.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new ResetPasswordNotification($token)
        );
    }

    /**
     * Indica si el usuario es administrador.
     */
    public function esAdministrador(): bool
    {
        return trim(
            mb_strtolower((string) $this->rol)
        ) === 'admin';
    }

    /**
     * Indica si el usuario es normal.
     */
    public function esUsuario(): bool
    {
        return trim(
            mb_strtolower((string) $this->rol)
        ) === 'usuario';
    }

    /**
     * Indica si la cuenta está activa.
     */
    public function estaActivo(): bool
    {
        return (bool) $this->activo;
    }

    /**
     * Devuelve el nombre legible del rol.
     */
    public function nombreRol(): string
    {
        return $this->esAdministrador()
            ? 'Administrador'
            : 'Usuario';
    }

    /**
     * Devuelve el nombre legible del estado.
     */
    public function nombreEstado(): string
    {
        return $this->estaActivo()
            ? 'Activo'
            : 'Inactivo';
    }
}