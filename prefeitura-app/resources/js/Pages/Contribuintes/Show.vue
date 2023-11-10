<template>
    <Head title="Contribuinte - Detalhes" />
    <!-- <section class="container mt-8 mx-auto px-40"> -->
        <section class="sm:mx-10 lg:mx-80 space-y-4 shadow-md pb-8 mb-6 rounded-md border-2">
            <nav class="flex bg-slate-200">
                <label for="opcao-contribuinte" class="py-2.5 px-4 cursor-pointer hover:bg-white hover:rounded-tl" v-bind:class="{'bg-white rounded-tl font-semibold' : opcao === 'contribuinte'}">
                    <input type="radio" value="contribuinte" id="opcao-contribuinte" name="opcao" v-model="opcao" class="hidden">Contribuinte
                </label>
                <label for="opcao-protocolos" class="py-2.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-white font-semibold' : opcao === 'protocolos'}">
                    <input type="radio" value="protocolos" id="opcao-protocolos" name="opcao" v-model="opcao" class="hidden">
                        Protocolos
                </label>
            </nav>

            <section class="px-8 py-4" v-if="opcao === 'contribuinte'">
                <h1 class="font-semibold text-lg mx-auto w-fit">Contribuinte # {{ contribuinte.id }}</h1>
                <h2 class="text-md font-semibold mt-4">Nome:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.nome }}</p>
                <h2 class="text-md font-semibold mt-4">Data de Nascimento:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ new Date(contribuinte.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) }}</p>
                <h2 class="text-md font-semibold mt-4">CPF:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') }}</p>
                <h2 class="text-md font-semibold mt-4">Sexo:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.sexo === "M" ? "Masculino" : "Feminino" }}</p>
                <h2 class="text-md font-semibold mt-4">Rua:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.rua ? contribuinte.rua : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Número:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.numero ? contribuinte.numero : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Complemento:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.complemento ? contribuinte.complemento : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Bairro:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.bairro ? contribuinte.bairro : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Cidade:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ contribuinte.cidade ? contribuinte.cidade : '---' }}</p>
            </section>

            <section class="px-8 py-4" v-if="opcao === 'protocolos'">
            <h1 class="font-semibold text-lg mx-auto w-fit mb-8">{{ protocolos.length ? 'Lista de Protocolos' : 'Sem Protocolos Cadastrados'}}</h1>
            <div class="bg-gray-200 p-4 rounded-md flex flex-col mb-2" v-for="protocolo in protocolos">
              <div class="flex justify-between">
                <div>
                  <h1 class="font-semibold text-lg">Protocolo # {{ protocolo.id }} - {{ protocolo.departamento.nome }}</h1>
                  <p class="text-xs">{{ new Date(protocolo.created_at).toLocaleString('pt-BR') }}</p>
                </div>
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-slate-700">
                        <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                        <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-slate-700">
                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                    </svg>

                </div>
              </div>
              <p class="mt-5">{{ protocolo.descricao }}</p>
              <div class="flex justify-between mt-8">
                <p>{{ protocolo.departamento.id }} - {{ protocolo.departamento.nome }}</p>
                <Link v-bind:href="route('protocolos-show', protocolo.id)">Ver</Link>
                <Link v-bind:href="route('protocolos-edit', protocolo.id)">Editar</Link>
                <Link @click="edit(protocolo.id)">Ver</Link>
              </div>
            </div>
        </section>

          
        
        
        </section>
        
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

    const opcao = ref('contribuinte');

    const page = usePage();

    let form = useForm({});

    const props = defineProps({
        contribuinte: Object,
        protocolos: Object
    });

    // let add = () => {
    //     form.post(route('protocolos-add-acompanhamento'), {
    //         preserveState: true,
    //         preserveScroll: true,
    //         onSuccess: () => form.reset('observacao'),
    //     });
    // }

    let edit = (id) => {
        form.get(route('protocolos-edit', id)), {
            preserveState: true,
            preserveScroll: true,
        }
    }
</script>