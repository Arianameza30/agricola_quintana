@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-8">

    <div class="bg-white rounded-xl shadow-lg p-6">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Nuevo Lote
        </h1>

        <form method="POST" action="{{ route('lotes.store') }}">

            @csrf

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Hacienda
                </label>

                <select
                    name="hacienda_id"
                    class="w-full border border-gray-300 rounded-lg p-2">

                    <option value="">Seleccione una hacienda</option>

                    @foreach($haciendas as $hacienda)

                        <option
                            value="{{ $hacienda->id }}"
                            {{ old('hacienda_id') == $hacienda->id ? 'selected' : '' }}>

                            {{ $hacienda->nombre }}

                        </option>

                    @endforeach

                </select>

                @error('hacienda_id')
                    <p class="text-red-600 mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Nombre del Lote
                </label>

                <input
                    type="text"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    class="w-full border border-gray-300 rounded-lg p-2">

                @error('nombre')
                    <p class="text-red-600 mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Hectáreas Productivas (Has. Prod.)
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="has_prod"
                    value="{{ old('has_prod') }}"
                    class="w-full border border-gray-300 rounded-lg p-2">

                @error('has_prod')
                    <p class="text-red-600 mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">

                    Guardar

                </button>

                <a href="{{ route('lotes.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

@endsection