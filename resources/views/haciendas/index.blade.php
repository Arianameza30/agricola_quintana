@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

        {{-- ========================================================= --}}
        {{-- CABECERA --}}
        {{-- ========================================================= --}}

        <div class="border-b border-gray-100 px-5 py-5 sm:px-6">

            <h1 class="text-2xl font-bold text-gray-900">
                Consulta de Haciendas
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Las haciendas se consultan automáticamente desde el sistema corporativo.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- TABLA DE HACIENDAS --}}
        {{-- ========================================================= --}}

        <div class="overflow-x-auto p-5 sm:p-6">

            <table class="min-w-full overflow-hidden rounded-xl border border-gray-200">

                <thead class="bg-green-100">

                    <tr class="text-left text-sm font-semibold text-green-900">

                        <th class="border-b border-green-200 px-4 py-3">
                            ID interno
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Nombre oficial
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Descripción
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Lotes
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Estado
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($haciendas as $hacienda)

                        <tr class="text-sm text-gray-700 transition hover:bg-green-50/40">

                            <td class="whitespace-nowrap px-4 py-3">
                                {{ $hacienda->id }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-gray-900">
                                {{ $hacienda->nombre }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $hacienda->descripcion ?: '—' }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 font-bold text-green-800">
                                {{ (int) $hacienda->lotes_count }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3">

                                @if($hacienda->estado)

                                    <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Activo
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        Inactivo
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-4 py-10 text-center text-sm text-gray-500"
                            >
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