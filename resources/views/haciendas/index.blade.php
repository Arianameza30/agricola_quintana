@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">

            <div class="flex justify-between items-center mb-4">

                <h2 class="text-2xl font-bold">
                    Listado de Haciendas
                </h2>

                <a href="{{ route('haciendas.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Nueva Hacienda
                </a>

            </div>

            <table class="min-w-full border border-gray-300">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Nombre</th>
                        <th class="border px-4 py-2 text-left">Descripción</th>
                        <th class="border px-4 py-2 text-left">Estado</th>
                        <th class="border px-4 py-2 text-center">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($haciendas as $hacienda)

                    <tr>

                        <td class="border px-4 py-2">
                            {{ $hacienda->id }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $hacienda->nombre }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $hacienda->descripcion }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $hacienda->estado ? 'Activo' : 'Inactivo' }}
                        </td>

                        <td class="border px-4 py-2 text-center">

                            <a href="{{ route('haciendas.edit', $hacienda) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mr-2">
                                Editar
                            </a>

                            <form action="{{ route('haciendas.destroy', $hacienda) }}"
                                  method="POST"
                                  class="inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('¿Está seguro de eliminar esta hacienda?')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                    Eliminar

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-4">
                            No existen haciendas registradas.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection