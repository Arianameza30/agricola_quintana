<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        Iniciar sesión | Agrícola Quintana
    </title>

    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        html,
        body {
            margin: 0;
            min-height: 100%;
            background: #14532d;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <main
        class="relative min-h-screen overflow-hidden bg-gradient-to-br from-green-950 via-green-900 to-emerald-800"
    >

        {{-- Decoración superior --}}

        <div
            class="pointer-events-none absolute -left-32 -top-32 h-96 w-96 rounded-full bg-lime-300/10 blur-3xl"
        ></div>

        {{-- Decoración inferior --}}

        <div
            class="pointer-events-none absolute -bottom-40 -right-32 h-[30rem] w-[30rem] rounded-full bg-emerald-200/10 blur-3xl"
        ></div>

        {{-- Contenedor del formulario --}}

        <div
            class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8 sm:px-6"
        >

            <div class="w-full max-w-md">

                {{ $slot }}

            </div>

        </div>

    </main>

</body>

</html>