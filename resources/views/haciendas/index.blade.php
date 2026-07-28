@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
        <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Gestión de Haciendas</h1>
                <p class="mt-1 text-sm text-gray-500">Administración de las haciendas registradas.</p>
            </div>

            <a
                href="{{ route('haciendas.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
            >
                <span class="text-lg leading-none">+</span>
                Nueva Hacienda
            </a>
        </div>

        <div class="overflow-x-auto p-5 sm:p-6">
            <table class="min-w-full overflow-hidden rounded-xl border border-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="border-b border-gray-200 px-4 py-3">ID</th>
                        <th class="border-b border-gray-200 px-4 py-3">Nombre</th>
                        <th class="border-b border-gray-200 px-4 py-3">Descripción</th>
                        <th class="border-b border-gray-200 px-4 py-3">Estado</th>
                        <th class="border-b border-gray-200 px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($haciendas as $hacienda)
                        <tr class="text-sm text-gray-700 transition hover:bg-green-50/40">
                            <td class="whitespace-nowrap px-4 py-3">{{ $hacienda->id }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $hacienda->nombre }}</td>
                            <td class="px-4 py-3">{{ $hacienda->descripcion ?: '—' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $hacienda->estado ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $hacienda->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center justify-center gap-2">
                                    <a
                                        href="{{ route('haciendas.edit', $hacienda) }}"
                                        class="inline-flex min-w-[92px] items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        Editar
                                    </a>

                                    <form action="{{ route('haciendas.destroy', $hacienda) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('¿Está seguro de eliminar esta hacienda?')"
                                            class="inline-flex min-w-[92px] items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                                        >
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
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
