@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Mi perfil
        </h1>

        <p class="mt-2 text-sm text-gray-600">
            Consulta y actualiza la información de tu cuenta.
        </p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
            La información del perfil se actualizó correctamente.
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-800">
            La contraseña se actualizó correctamente.
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">

        <div class="overflow-hidden rounded-2xl border bg-white shadow-sm lg:col-span-2">

            <div class="bg-green-950 px-6 py-5">
                <h2 class="text-xl font-bold text-white">
                    Información de la cuenta
                </h2>
            </div>

            <div class="grid gap-4 p-6 sm:grid-cols-2">

                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-xs uppercase text-gray-500">Nombre</p>
                    <p class="mt-2 font-semibold">{{ $user->name }}</p>
                </div>

                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-xs uppercase text-gray-500">Correo</p>
                    <p class="mt-2 font-semibold break-all">{{ $user->email }}</p>
                </div>

                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-xs uppercase text-gray-500">Rol</p>

                    @if($user->esAdministrador())
                        <span class="mt-2 inline-flex rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-800">
                            Administrador
                        </span>
                    @else
                        <span class="mt-2 inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-800">
                            Usuario
                        </span>
                    @endif
                </div>

                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-xs uppercase text-gray-500">Estado</p>

                    @if($user->estaActivo())
                        <span class="mt-2 inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                            Activo
                        </span>
                    @else
                        <span class="mt-2 inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-800">
                            Inactivo
                        </span>
                    @endif
                </div>

                <div class="rounded-xl bg-gray-50 p-4 sm:col-span-2">
                    <p class="text-xs uppercase text-gray-500">Fecha de registro</p>
                    <p class="mt-2 font-semibold">
                        {{ $user->created_at?->format('d/m/Y') }}
                    </p>
                </div>

            </div>

        </div>

        <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">

            <div class="border-b px-6 py-5">
                <h2 class="text-xl font-bold">
                    Mi actividad
                </h2>
            </div>

            <div class="space-y-4 p-6">

                <div class="rounded-xl bg-green-50 p-4">
                    <p class="text-sm text-green-700">
                        Recorridos registrados
                    </p>

                    <p class="text-3xl font-bold text-green-900">
                        {{ $totalRecorridos }}
                    </p>
                </div>

                <div class="rounded-xl border p-4">
                    <p class="text-xs uppercase text-gray-500">
                        Último recorrido
                    </p>

                    <p class="mt-2 font-semibold">
                        @if($ultimoRecorrido)
                            Semana {{ $ultimoRecorrido->semana }} / {{ $ultimoRecorrido->anio }}
                        @else
                            No existen registros.
                        @endif
                    </p>
                </div>

                <div class="rounded-xl border p-4">
                    <p class="text-xs uppercase text-gray-500">
                        Última hacienda
                    </p>

                    <p class="mt-2 font-semibold">
                        {{ $ultimaHacienda?->nombre ?? 'No existen registros.' }}
                    </p>
                </div>

            </div>

        </div>

    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">

        <div class="rounded-2xl border bg-white p-6 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-2xl border bg-white p-6 shadow-sm">
            @include('profile.partials.update-password-form')
        </div>

    </div>

</div>

@endsection