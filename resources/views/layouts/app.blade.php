<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Agrícola Quintana</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen">

        <aside
            id="menuLateral"
            class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-green-950 text-white shadow-xl transition-transform duration-300 md:static md:translate-x-0"
        >
            <div class="border-b border-white/10 px-5 py-5">
                <a
                    href="{{ route('recorridos.index') }}"
                    class="block rounded-xl bg-white p-3 shadow-sm"
                >
                    <img
                        src="{{ asset('images/logo_agricola_quintana.png') }}"
                        alt="Agrícola Quintana"
                        class="h-14 w-full object-contain"
                    >
                </a>

                <p class="mt-3 text-center text-xs font-medium uppercase tracking-[0.18em] text-green-200">
                    Sistema de Gestión Agrícola
                </p>
            </div>

            <div class="border-b border-white/10 px-5 py-4">
                <p class="text-xs uppercase tracking-wider text-green-300">
                    Usuario
                </p>

                <p class="mt-1 truncate font-semibold text-white">
                    {{ auth()->user()->name }}
                </p>

                <p class="truncate text-xs text-green-200">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <nav class="flex-1 space-y-1.5 overflow-y-auto px-4 py-5">

                {{-- RECORRIDOS: VISIBLE PARA TODOS --}}
                <a
                    href="{{ route('recorridos.index') }}"
                    class="{{ request()->routeIs('recorridos.*')
                        ? 'bg-green-600 text-white shadow-sm'
                        : 'text-green-100 hover:bg-white/10 hover:text-white'
                    }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5h6M9 9h6M9 13h3M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                        />
                    </svg>

                    Recorridos
                </a>

                {{-- SOLO PARA ADMINISTRADORES --}}
                @if(auth()->user()->esAdministrador())

                    <a
                        href="{{ route('haciendas.index') }}"
                        class="{{ request()->routeIs('haciendas.*')
                            ? 'bg-green-600 text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white'
                        }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21V10m0 0c-4 0-7-2.5-7-6 4 0 7 2.5 7 6Zm0 3c4 0 7-2.5 7-6-4 0-7 2.5-7 6Z"
                            />
                        </svg>

                        Haciendas
                    </a>

                    <a
                        href="{{ route('lotes.index') }}"
                        class="{{ request()->routeIs(
                            'lotes.index',
                            'lotes.create',
                            'lotes.show',
                            'lotes.edit'
                        )
                            ? 'bg-green-600 text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white'
                        }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m4 4 7-2 9 3v15l-7-2-9 3V4Zm7-2v16m2-13v13"
                            />
                        </svg>

                        Lotes
                    </a>

                    <a
                        href="{{ route('lotes.configurar') }}"
                        class="{{ request()->routeIs('lotes.configurar')
                            ? 'bg-green-600 text-white shadow-sm'
                            : 'text-green-100 hover:bg-white/10 hover:text-white'
                        }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition"
                    >
                        <svg
                            class="h-5 w-5 shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21s6-5.2 6-11a6 6 0 1 0-12 0c0 5.8 6 11 6 11Z"
                            />

                            <circle
                                cx="12"
                                cy="10"
                                r="2"
                            />
                        </svg>

                        Configurar coordenadas
                    </a>

                @endif

                {{-- PERFIL: VISIBLE PARA TODOS --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="{{ request()->routeIs('profile.*')
                        ? 'bg-green-600 text-white shadow-sm'
                        : 'text-green-100 hover:bg-white/10 hover:text-white'
                    }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="8"
                            r="4"
                        />

                        <path
                            stroke-linecap="round"
                            d="M4 21a8 8 0 0 1 16 0"
                        />
                    </svg>

                    Perfil
                </a>
            </nav>

            <div class="border-t border-white/10 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-green-100 transition hover:bg-red-600 hover:text-white"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-3m-3-4h10m0 0-3-3m3 3-3 3"
                            />
                        </svg>

                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <div class="min-w-0 flex-1">

            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-gray-200 bg-white/95 px-4 shadow-sm backdrop-blur sm:px-6">

                <div class="flex items-center gap-3">
                    <button
                        id="btnAbrirMenu"
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100 md:hidden"
                        aria-label="Abrir menú"
                    >
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                d="M4 7h16M4 12h16M4 17h16"
                            />
                        </svg>
                    </button>

                    <div>
                        <p class="font-bold text-gray-900">
                            Sistema de Gestión Agrícola
                        </p>

                        <p class="hidden text-xs text-gray-500 sm:block">
                            Agrícola Quintana
                        </p>
                    </div>
                </div>

                <div class="rounded-lg bg-green-50 px-3 py-2 text-sm font-semibold text-green-800">
                    {{ now()->format('d/m/Y') }}
                </div>
            </header>

            <main class="min-h-[calc(100vh-4rem)]">
                @yield('content')
            </main>
        </div>
    </div>

    <div
        id="fondoMenu"
        class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm md:hidden"
    ></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menu = document.getElementById('menuLateral');
            const button = document.getElementById('btnAbrirMenu');
            const overlay = document.getElementById('fondoMenu');

            if (!menu || !button || !overlay) {
                return;
            }

            const openMenu = () => {
                menu.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeMenu = () => {
                menu.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            button.addEventListener('click', openMenu);
            overlay.addEventListener('click', closeMenu);

            window.addEventListener('keydown', event => {
                if (event.key === 'Escape') {
                    closeMenu();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>