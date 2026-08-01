@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

        {{-- ========================================================= --}}
        {{-- CABECERA --}}
        {{-- ========================================================= --}}

        <div class="border-b border-gray-100 px-5 py-5 sm:px-6">

            <h1 class="text-2xl font-bold text-gray-900">
                Consulta de Lotes
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Los lotes y las hectáreas productivas se consultan automáticamente desde el sistema corporativo.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- TABLA DE LOTES --}}
        {{-- ========================================================= --}}

        <div class="overflow-x-auto p-5 sm:p-6">

            <table class="min-w-full overflow-hidden rounded-xl border border-gray-200">

                <thead class="bg-green-100">

                    <tr class="text-left text-sm font-semibold text-green-900">

                        <th class="border-b border-green-200 px-4 py-3">
                            ID
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Hacienda
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Lote
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Has. Prod. oficiales
                        </th>

                        <th class="border-b border-green-200 px-4 py-3">
                            Estado
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($lotes as $lote)

                        <tr class="text-sm text-gray-700 transition hover:bg-green-50/40">

                            <td class="whitespace-nowrap px-4 py-3">
                                {{ $lote->id }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-gray-900">
                                {{ $lote->hacienda->nombre }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $lote->nombre }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-green-800">
                                {{ number_format((float) $lote->has_prod, 2) }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3">

                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $lote->estado ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $lote->estado ? 'Activo' : 'Inactivo' }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-4 py-10 text-center text-sm text-gray-500"
                            >
                                No existen lotes registrados.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection