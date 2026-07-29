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
                        d="M15.232 5.232l3.536 3.536M9 11l6.232-6.232a2.5 2.5 0 013.536 3.536L12.536 14.536A4 4 0 019.707 15.707L7 16l.293-2.707A4 4 0 018.464 10.464L9 11zm-2 7H5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 00-2-2h-2"
                    />
                </svg>
            </div>

            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Actualizar información
                </h2>

                <p class="mt-1 text-sm leading-6 text-gray-500">
                    Modifica el nombre y el correo electrónico asociados a tu cuenta.
                </p>

            </div>

        </div>

    </div>


    @if (session('status') === 'profile-updated')

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
                La información del perfil se actualizó correctamente.
            </span>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="mt-6 space-y-5"
    >

        @csrf
        @method('patch')


        <div>

            <label
                for="name"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Nombre
            </label>

            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-200"
            >

            @error('name')

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

                    {{ $message }}

                </p>

            @enderror

        </div>


        <div>

            <label
                for="email"
                class="mb-2 block text-sm font-semibold text-gray-700"
            >
                Correo electrónico
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-200"
            >

            @error('email')

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

                    {{ $message }}

                </p>

            @enderror

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
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                Guardar cambios

            </button>

        </div>

    </form>

</section>