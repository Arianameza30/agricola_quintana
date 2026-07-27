<x-guest-layout>

    <section
        class="overflow-hidden rounded-3xl border border-white/20 bg-white shadow-2xl"
    >

        {{-- ========================================================= --}}
        {{-- CABECERA CORPORATIVA --}}
        {{-- ========================================================= --}}

        <div
            class="bg-gradient-to-r from-green-950 via-green-900 to-green-800 px-8 pb-7 pt-8 text-center"
        >

            <div
                class="mx-auto flex w-full max-w-sm items-center justify-center rounded-2xl bg-white px-5 py-4 shadow-lg"
            >

                <img
                    src="{{ asset('images/logo_agricola_quintana.png') }}"
                    alt="Logo de Agrícola Quintana"
                    class="h-auto max-h-28 w-full object-contain"
                >

            </div>

            <h1
                class="mt-6 text-2xl font-extrabold tracking-tight text-white"
            >
                Bienvenido
            </h1>

            <p
                class="mt-2 text-sm text-green-100"
            >
                Ingresa tus credenciales para acceder al sistema.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- FORMULARIO --}}
        {{-- ========================================================= --}}

        <div class="px-7 py-7 sm:px-9">

            <x-auth-session-status
                class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
                :status="session('status')"
            />


            <form
                method="POST"
                action="{{ route('login') }}"
                class="space-y-5"
            >

                @csrf


                {{-- ================================================= --}}
                {{-- CORREO ELECTRÓNICO --}}
                {{-- ================================================= --}}

                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Correo electrónico
                    </label>

                    <div class="relative">

                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 6.75A2.25 2.25 0 0 1 5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 17.25V6.75Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m3.75 7.5 6.91 5.182a2.25 2.25 0 0 0 2.68 0L20.25 7.5"
                                />
                            </svg>

                        </div>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="correo@ejemplo.com"
                            class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 pl-12 pr-4 text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-green-600 focus:bg-white focus:ring-green-600"
                        >

                    </div>

                    @if ($errors->has('email'))

                        <p
                            class="mt-2 text-sm font-medium text-red-600"
                        >
                            {{ $errors->first('email') }}
                        </p>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- CONTRASEÑA --}}
                {{-- ================================================= --}}

                <div>

                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Contraseña
                    </label>

                    <div class="relative">

                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 10.5h10.5A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21H6.75A2.25 2.25 0 0 1 4.5 18.75v-6a2.25 2.25 0 0 1 2.25-2.25Z"
                                />
                            </svg>

                        </div>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Ingresa tu contraseña"
                            class="block w-full rounded-xl border-gray-300 bg-gray-50 py-3 pl-12 pr-12 text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-green-600 focus:bg-white focus:ring-green-600"
                        >

                        <button
                            id="btnMostrarPassword"
                            type="button"
                            aria-label="Mostrar u ocultar contraseña"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-green-700 focus:outline-none"
                        >

                            <svg
                                id="iconoOjo"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="2.25"
                                />
                            </svg>

                        </button>

                    </div>

                    @if ($errors->has('password'))

                        <p
                            class="mt-2 text-sm font-medium text-red-600"
                        >
                            {{ $errors->first('password') }}
                        </p>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- RECORDAR Y RECUPERAR CONTRASEÑA --}}
                {{-- ================================================= --}}

                <div
                    class="flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between"
                >

                    <label
                        for="remember_me"
                        class="inline-flex cursor-pointer items-center"
                    >

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-green-700 shadow-sm focus:ring-green-600"
                        >

                        <span class="ml-2 text-gray-600">
                            Recordarme
                        </span>

                    </label>


                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="font-semibold text-green-700 transition hover:text-green-900 hover:underline"
                        >
                            ¿Olvidaste tu contraseña?
                        </a>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- BOTÓN DE INICIAR SESIÓN --}}
                {{-- ================================================= --}}

                <button
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-700 px-5 py-3.5 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-green-900/20 transition hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 active:scale-[0.99]"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m18 15 3-3m0 0-3-3m3 3H9"
                        />
                    </svg>

                    <span>
                        Iniciar sesión
                    </span>

                </button>

            </form>


            {{-- ===================================================== --}}
            {{-- REGISTRO DE USUARIO --}}
            {{-- ===================================================== --}}

            @if (Route::has('register'))

                <div class="mt-6">

                    <div class="relative flex items-center">

                        <div class="flex-grow border-t border-gray-200"></div>

                        <span
                            class="mx-3 flex-shrink text-xs font-medium text-gray-400"
                        >
                            ¿No tienes una cuenta?
                        </span>

                        <div class="flex-grow border-t border-gray-200"></div>

                    </div>


                    <a
                        href="{{ route('register') }}"
                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl border-2 border-green-700 bg-white px-5 py-3.5 text-sm font-bold uppercase tracking-wide text-green-700 shadow-sm transition hover:bg-green-50 hover:text-green-800 focus:outline-none focus:ring-4 focus:ring-green-200 active:scale-[0.99]"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="h-5 w-5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 3.9.872 9.337 9.337 0 0 0 4.1-.949 4.125 4.125 0 0 0-7.579-2.298"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.128v-.003c0-1.113-.285-2.16-.786-3.071A6.75 6.75 0 0 0 8.25 12.5a6.75 6.75 0 0 0-5.964 3.554A6.702 6.702 0 0 0 1.5 19.125v.003A9.721 9.721 0 0 0 8.25 21c2.549 0 4.877-.977 6.75-1.872Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M11.25 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 7.5v6M21 10.5h-6"
                            />

                        </svg>

                        <span>
                            Registrar usuario
                        </span>

                    </a>

                </div>

            @endif


            {{-- ===================================================== --}}
            {{-- PIE DEL FORMULARIO --}}
            {{-- ===================================================== --}}

            <div
                class="mt-7 border-t border-gray-100 pt-5 text-center"
            >

                <p
                    class="text-xs text-gray-500"
                >
                    Acceso exclusivo para personal autorizado.
                </p>

                <p
                    class="mt-1 text-xs font-semibold text-green-800"
                >
                    Agrícola Quintana
                </p>

            </div>

        </div>

    </section>


    <p
        class="mt-5 text-center text-xs text-green-100/90"
    >
        Sistema de Gestión de Recorridos Agrícolas
    </p>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const campoPassword =
                document.getElementById('password');

            const botonMostrar =
                document.getElementById('btnMostrarPassword');

            if (!campoPassword || !botonMostrar) {
                return;
            }

            botonMostrar.addEventListener('click', function () {

                const oculto =
                    campoPassword.type === 'password';

                campoPassword.type =
                    oculto ? 'text' : 'password';

                botonMostrar.setAttribute(
                    'aria-label',
                    oculto
                        ? 'Ocultar contraseña'
                        : 'Mostrar contraseña'
                );

            });

        });

    </script>

</x-guest-layout>