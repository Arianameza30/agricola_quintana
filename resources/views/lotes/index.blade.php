@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6">

        <div class="flex justify-between items-center mb-6">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Gestión de Lotes
                </h1>

                <p class="text-gray-500">
                    Administración de los lotes de las haciendas
                </p>

            </div>

            <a href="{{ route('lotes.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

                + Nuevo Lote

            </a>

        </div>

        <table class="min-w-full border border-gray-300">

            <thead class="bg-gray-100">

                <tr>

                    <th class="border px-4 py-3">ID</th>
                    <th class="border px-4 py-3">Hacienda</th>
                    <th class="border px-4 py-3">Lote</th>
                    <th class="border px-4 py-3">Has. Prod.</th>
                    <th class="border px-4 py-3">Estado</th>
                    <th class="border px-4 py-3">Acciones</th>

                </tr>

            </thead>

            <tbody>

            @forelse($lotes as $lote)

                <tr>

                    <td class="border px-4 py-2">
                        {{ $lote->id }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $lote->hacienda->nombre }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $lote->nombre }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $lote->has_prod }}
                    </td>

                    <td class="border px-4 py-2">

                        @if($lote->estado)

                            <span class="text-green-600 font-semibold">
                                Activo
                            </span>

                        @else

                            <span class="text-red-600 font-semibold">
                                Inactivo
                            </span>

                        @endif

                    </td>

                    <td class="border px-4 py-2 text-center">

                        <a href="{{ route('lotes.edit', $lote) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">

                            Editar

                        </a>

                        <form
                            action="{{ route('lotes.destroy', $lote) }}"
                            method="POST"
                            class="inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm('¿Desea eliminar este lote?')"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                Eliminar

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6"
                        class="text-center py-6 text-gray-500">

                        No existen lotes registrados.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection