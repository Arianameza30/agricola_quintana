<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        'usuario',
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
     * Crear automáticamente un usuario cuando no se envíe uno.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            if (
                filled($user->usuario)
            ) {
                $user->usuario = static::normalizarUsuario(
                    (string) $user->usuario
                );

                return;
            }

            $parteCorreo = Str::before(
                (string) $user->email,
                '@'
            );

            $usuarioBase = static::normalizarUsuario(
                $parteCorreo
            );

            if ($usuarioBase === '') {
                $usuarioBase = static::normalizarUsuario(
                    (string) $user->name
                );
            }

            if ($usuarioBase === '') {
                $usuarioBase = 'usuario';
            }

            $usuarioFinal = $usuarioBase;
            $contador = 1;

            while (
                DB::table('users')
                    ->where('usuario', $usuarioFinal)
                    ->exists()
            ) {
                $usuarioFinal = $usuarioBase.'_'.$contador;
                $contador++;
            }

            $user->usuario = $usuarioFinal;
        });
    }

    /**
     * Normalizar el nombre de usuario.
     */
    private static function normalizarUsuario(
        string $usuario
    ): string {
        return Str::lower(
            Str::slug(
                trim($usuario),
                '_'
            )
        );
    }

    /**
     * Recorridos creados por el usuario.
     */
    public function recorridos(): HasMany
    {
        return $this->hasMany(
            Recorrido::class
        );
    }

    /**
     * Enviar la notificación para restablecer la contraseña.
     */
    public function sendPasswordResetNotification(
        $token
    ): void {
        $this->notify(
            new ResetPasswordNotification($token)
        );
    }

    /**
     * Indicar si el usuario es administrador.
     */
    public function esAdministrador(): bool
    {
        return trim(
            mb_strtolower(
                (string) $this->rol
            )
        ) === 'admin';
    }

    /**
     * Indicar si el usuario es normal.
     */
    public function esUsuario(): bool
    {
        return trim(
            mb_strtolower(
                (string) $this->rol
            )
        ) === 'usuario';
    }

    /**
     * Indicar si la cuenta está activa.
     */
    public function estaActivo(): bool
    {
        return (bool) $this->activo;
    }

    /**
     * Devolver el nombre legible del rol.
     */
    public function nombreRol(): string
    {
        return $this->esAdministrador()
            ? 'Administrador'
            : 'Usuario';
    }

    /**
     * Devolver el nombre legible del estado.
     */
    public function nombreEstado(): string
    {
        return $this->estaActivo()
            ? 'Activo'
            : 'Inactivo';
    }
}