<section>

    <div class="border-b border-gray-200 pb-5">

        <div class="flex items-start gap-3">

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-700"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 0v2m-7 8h14a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2z"
                    />
                </svg>
            </div>

            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Cambiar contraseña
                </h2>

                <p class="mt-1 text-sm leading-6 text-gray-500">
                    Utiliza una contraseña segura para proteger tu cuenta.
                </p>

            </div>

        </div>

    </div>


    @if (session('status') === 'password-updated')

        <div
            class="mt-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="mt-0.5 h-5 w-5 shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>

            <span>
                La contraseña se actualizó correctamente.
            </span>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="mt-6 space-y-5"
    >

        @csrf
        @method('put')


        <div>

            <label
                for="update_password_current_password"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Contraseña actual
            </label>

            <input
                id="update_password_current_password"
                type="password"
                name="current_password"
                required
                autocomplete="current-password"
                class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-200"
            >

            @if ($errors->updatePassword->has('current_password'))

                <p class="mt-2 flex items-center gap-1 text-sm font-medium text-red-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                        />
                    </svg>

                    {{ $errors->updatePassword->first('current_password') }}

                </p>

            @endif

        </div>


        <div>

            <label
                for="update_password_password"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Nueva contraseña
            </label>

            <input
                id="update_password_password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-200"
            >

            <p class="mt-2 text-xs text-gray-500">
                Utiliza al menos 8 caracteres.
            </p>

            @if ($errors->updatePassword->has('password'))

                <p class="mt-2 flex items-center gap-1 text-sm font-medium text-red-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                        />
                    </svg>

                    {{ $errors->updatePassword->first('password') }}

                </p>

            @endif

        </div>


        <div>

            <label
                for="update_password_password_confirmation"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Confirmar nueva contraseña
            </label>

            <input
                id="update_password_password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-200"
            >

            @if ($errors->updatePassword->has('password_confirmation'))

                <p class="mt-2 flex items-center gap-1 text-sm font-medium text-red-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                        />
                    </svg>

                    {{ $errors->updatePassword->first('password_confirmation') }}

                </p>

            @endif

        </div>


        <div class="flex justify-end border-t border-gray-100 pt-5">

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-700 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-200"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V8a5 5 0 00-10 0v3H6a2 2 0 00-2 2v6a2 2 0 002 2zm3-10V8a3 3 0 016 0v3H9z"
                    />
                </svg>

                Actualizar contraseña

            </button>

        </div>

    </form>

</section>