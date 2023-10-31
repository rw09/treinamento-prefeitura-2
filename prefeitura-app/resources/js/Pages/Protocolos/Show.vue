<template>
    <Head title="Protocolos - Detalhes" />
    <!-- <section class="container mt-8 mx-auto px-40"> -->
        <section class="sm:mx-10 lg:mx-80 space-y-4 shadow-md pb-8 rounded-md border-2">
            <nav class="flex bg-slate-200">
                <label for="opcao-protocolo" class="py-2.5 px-4 cursor-pointer" v-bind:class="{'bg-gray-50 rounded-tl font-semibold' : opcao === 'protocolo'}">
                    <input type="radio" value="protocolo" id="opcao-protocolo" name="opcao" v-model="opcao" class="hidden">
                        Protocolo
                    </label>
                <label for="opcao-contribuinte" class="py-2.5 px-4 cursor-pointer bg-slate-200" v-bind:class="{'bg-gray-50 font-semibold' : opcao === 'contribuinte'}">
                    <input type="radio" value="contribuinte" id="opcao-contribuinte" name="opcao" v-model="opcao" class="hidden">Contribuinte
                </label>
                <label for="opcao-acompanhamentos" class="py-2.5 px-4 cursor-pointer bg-slate-200" v-bind:class="{'bg-gray-50 font-semibold' : opcao === 'acompanhamentos'}">
                    <input type="radio" value="acompanhamentos" id="opcao-acompanhamentos" name="opcao" v-model="opcao" class="hidden">Acompanhamentos
                </label>
            </nav>

            <section class="px-8 py-4" v-if="opcao === 'protocolo'">
                <h1 class="font-semibold text-lg mx-auto w-fit">Protocolo # {{protocolo.id}}</h1>
                <h2 class="text-md font-semibold mt-4">Descrição:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.descricao }}</p>
                <h2 class="text-md font-semibold mt-4">Data:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ new Date(protocolo.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) }}</p>
                <h2 class="text-md font-semibold mt-4">Prazo:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.prazo }} dias</p>
                <h2 class="text-md font-semibold mt-4">Departamento:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.departamento.nome}}</p>
            </section>
        

        <section class="px-8 py-4" v-if="opcao === 'acompanhamentos'">
            <button class="bg-green-300 px-3 py-2 mb-2">Novo Acompanhamento</button>
            <div class="bg-yellow-200 p-4 rounded-md flex flex-col mb-2" v-for="acompanhamento, index in acompanhamentos">
              <div class="flex justify-between">
                <div>
                  <h1 class="font-semibold text-lg">Acompanhamento # {{ acompanhamentos.length - index }}</h1>
                  <p class="text-xs">{{ new Date(acompanhamento.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'}) }}</p>
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
              <p class="mt-5">{{ acompanhamento.observacao }}</p>
              <div class="flex justify-end mt-8">
                <p>{{ acompanhamento.user_id }} - {{ acompanhamento.user.name }}</p>
              </div>
            </div>
          </section>
        
        </section>
        <form @submit.prevent="add" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100 grid grid-cols-2">
            <h1 class="font-bold mx-auto col-span-2">Protocolo Número #{{ protocolo.id }}</h1>
            <p>{{ protocolo.descricao }}</p>
            <p><strong>Data Cadastro:</strong> {{ new Date(protocolo.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'}) }}</p>
            <p><strong>Departamento:</strong> {{ protocolo.departamento.nome }}</p>
            <p><strong>Solicitante:</strong> {{ protocolo.contribuinte.nome }}</p>
            <div class="col-span-2">
                <label for="observacao">Acompanhamento:</label>
                <textarea v-model="form.observacao" cols="70" rows="8">
                </textarea>
            </div>
            <button class="py-1 px-2 bg-green-400" type="submit">Registrar Acompanhamento</button>
        </form>
        <div>
            <h2>Acompanhamentos:</h2>
            <ul>
                <li class="bg-yellow-500/50 p-4 mb-2" v-for="acompanhamento in acompanhamentos">
                    <div>
                        {{ acompanhamento.observacao }}
                    </div>
                    <div class="text-sm">
                        {{ new Date(acompanhamento.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'}) }}
                    </div>
                    <div>
                      {{ acompanhamento.user_id }} - {{ acompanhamento.user.name }}
                    </div>
                </li>
            </ul>
        </div>
    <!-- </section> -->
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

    const opcao = ref('protocolo');

    const page = usePage();

    const props = defineProps({
        protocolo: Object,
        acompanhamentos: Object
    });

    let form = useForm({
        protocolo_id: props.protocolo.id,
        user_id: page.props.auth.user.id,
        observacao: null,
    });

    let add = () => {
        form.post(route('protocolos-add-acompanhamento'), {
            preserveState: false,
        });
    }

    // let add = () => {
    //     form.post('/protocolos/add-acompanhamento', {
    //         onSuccess: form.reset(),
    //     });
    // }
</script>