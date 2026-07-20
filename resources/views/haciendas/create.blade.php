@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Nueva Hacienda
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form method="POST" action="{{ route('haciendas.store') }}">

                    @csrf

                    <div class="mb-4">

                        <label class="block mb-2 font-semibold">
                            Nombre
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            class="border border-gray-300 rounded w-full p-2">

                        @error('nombre')
                            <p class="text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2 font-semibold">
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            rows="5"
                            class="border border-gray-300 rounded w-full p-2">{{ old('descripcion') }}</textarea>

                    </div>

                    <button
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">

                        Guardar Hacienda

                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection