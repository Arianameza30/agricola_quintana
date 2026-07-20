@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-6">

    <!-- CABECERA -->
    <div class="bg-green-800 rounded-xl shadow-lg p-6 text-white">

        <h1 class="text-4xl font-bold">
            Registro de Área Recorrida
        </h1>

        <p class="text-green-200">
            Agrícola Quintana
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-8">

            <!-- HACIENDA -->
            <div>

                <label class="block mb-2 font-semibold">
                    Hacienda
                </label>

                <select
                    id="hacienda"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2">

                    <option value="">
                        Seleccione una hacienda
                    </option>

                    @foreach($haciendas as $hacienda)

                        <option value="{{ $hacienda->id }}">
                            {{ strtoupper($hacienda->nombre) }}
                        </option>

                    @endforeach

                </select>

            </div>

            <!-- SEMANA -->
            <div>

                <label class="block mb-2 font-semibold">
                    Semana
                </label>

                <select
                    id="semana"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2">

                    <option value="">
                        Seleccione semana
                    </option>

                    @for($i=1;$i<=53;$i++)

                        <option value="{{$i}}">
                            Semana {{$i}}
                        </option>

                    @endfor

                </select>

            </div>

            <!-- FECHA -->
            <div>

                <label class="block mb-2 font-semibold">
                    Fecha
                </label>

                <input
                    id="fecha"
                    type="date"
                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-3 py-2">

            </div>

            <!-- USUARIO -->
            <div>

                <label class="block mb-2 font-semibold">
                    Usuario
                </label>

                <input
                    readonly
                    value="{{ auth()->user()->name }}"
                    class="w-full rounded-lg border border-gray-300 bg-gray-200 text-black px-3 py-2">

            </div>

        </div>

        <div class="mt-6">

            <button
                id="btnAbrir"
                class="bg-white text-green-800 px-6 py-3 rounded-lg font-bold hover:bg-green-100">

                Abrir Semana

            </button>

        </div>

    </div>

    <!-- MAPA -->

    <div class="bg-white rounded-xl shadow-lg mt-8">

        <div class="bg-green-800 text-white px-5 py-3 rounded-t-xl">

            <h2 class="font-semibold">
                Mapa de Hacienda
            </h2>

        </div>

        <div class="p-6">

            <img
                id="mapa"
                src="{{ asset('mapas/domenica.png') }}"
                class="mx-auto border rounded-lg w-full">

        </div>

    </div>

    <!-- MATRIZ -->

    <div
        id="contenedorMatriz"
        class="hidden bg-white rounded-xl shadow-lg mt-8 p-6">

    </div>

</div>

<script>

const hacienda=document.getElementById('hacienda');
const semana=document.getElementById('semana');
const mapa=document.getElementById('mapa');
const btnAbrir=document.getElementById('btnAbrir');
const matriz=document.getElementById('contenedorMatriz');

hacienda.addEventListener('change',function(){

    let texto=this.options[this.selectedIndex].text.toUpperCase();

    if(texto.includes('DOMENICA')){

        mapa.src="{{ asset('mapas/domenica.png') }}";

    }else{

        mapa.src="{{ asset('mapas/maria_maria.png') }}";

    }

});

btnAbrir.addEventListener('click',async function(){

    if(hacienda.value==""){

        alert("Seleccione una hacienda");

        return;

    }

    if(semana.value==""){

        alert("Seleccione una semana");

        return;

    }

    matriz.classList.remove("hidden");

    matriz.innerHTML=`

        <div class="text-center py-10">

            Consultando información...

        </div>

    `;

    const respuesta=await fetch("{{ route('recorridos.abrir') }}",{

        method:"POST",

        headers:{

            "Content-Type":"application/json",

            "X-CSRF-TOKEN":document
            .querySelector('meta[name="csrf-token"]')
            .content

        },

        body:JSON.stringify({

            hacienda_id:hacienda.value,

            semana:semana.value,

            anio:new Date().getFullYear()

        })

    });

    const datos=await respuesta.json();

   console.log(datos);

matriz.innerHTML = `
<pre>${JSON.stringify(datos, null, 2)}</pre>
`;

});
</script>

@endsection