@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-2xl font-bold mb-6">
                Editar Hacienda
            </h2>

            <form method="POST" action="{{ route('haciendas.update', $hacienda->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-2 font-semibold">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $hacienda->nombre) }}"
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
                        class="border border-gray-300 rounded w-full p-2">{{ old('descripcion', $hacienda->descripcion) }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                        Actualizar
                    </button>

                    <a
                        href="{{ route('haciendas.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection