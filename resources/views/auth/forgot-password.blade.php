<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar contraseña</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-green-950 via-green-900 to-green-700">
<main class="flex min-h-screen items-center justify-center px-4 py-10">
<div class="w-full max-w-md">
<div class="overflow-hidden rounded-3xl bg-white shadow-2xl">
<div class="bg-green-950 px-8 py-10 text-center">
<h1 class="text-3xl font-bold text-white">Recuperar contraseña</h1>
<p class="mt-3 text-sm leading-6 text-green-100">
Ingrese el correo electrónico asociado a su cuenta y le enviaremos un enlace para restablecer tu contraseña.
</p>
</div>
<div class="px-8 py-8">
@if (session('status'))
<div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
{{ session('status') }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
@csrf

<div>
<label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
Correo electrónico
</label>

<input
id="email"
type="email"
name="email"
value="{{ old('email') }}"
required
autofocus
autocomplete="email"
placeholder="correo@ejemplo.com"
class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm shadow-sm focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-200">

@error('email')
<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
@enderror
</div>

<button type="submit"
class="w-full rounded-xl bg-green-700 px-5 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-lg transition hover:bg-green-800">
Enviar enlace de recuperación
</button>

</form>

<div class="mt-8 border-t pt-6 text-center">
<a href="{{ route('login') }}" class="font-semibold text-green-700 hover:text-green-900">
← Volver al inicio de sesión
</a>
</div>

</div>
</div>

<p class="mt-5 text-center text-xs text-green-100">
Sistema de Gestión Agrícola · Agrícola Quintana
</p>

</div>
</main>
</body>
</html>