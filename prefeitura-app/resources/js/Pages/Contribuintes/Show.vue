<template>
    <Head title="Contribuinte - Detalhes" />
    <!-- <section class="container mt-8 mx-auto px-40"> -->
        <section class="sm:mx-10 lg:mx-80 space-y-4 shadow-md pb-8 mb-6 rounded-md border">
            <nav class="flex bg-gray-200 mb-6">
                <label for="opcao-contribuinte" class="py-3.5 px-4 cursor-pointer hover:bg-white hover:rounded-tl" v-bind:class="{'bg-gray-50 rounded-tl font-semibold' : opcao === 'contribuinte'}">
                    <input type="radio" value="contribuinte" id="opcao-contribuinte" name="opcao" v-model="opcao" class="hidden">Contribuinte
                </label>
                <label for="opcao-protocolos" class="py-3.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-gray-50 font-semibold' : opcao === 'protocolos'}">
                    <input type="radio" value="protocolos" id="opcao-protocolos" name="opcao" v-model="opcao" class="hidden">
                        Protocolos
                </label>
            </nav>

            <section class="px-8 py-4" v-if="opcao === 'contribuinte'">
                <h1 class="font-semibold text-lg mx-auto w-fit mb-4">Contribuinte # {{ contribuinte.id }}</h1>
                <h2 class="text-md font-semibold mt-4">Nome:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.nome }}</p>
                <h2 class="text-md font-semibold mt-4">Data de Nascimento:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ new Date(contribuinte.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) }}</p>
                <h2 class="text-md font-semibold mt-4">CPF:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') }}</p>
                <h2 class="text-md font-semibold mt-4">Sexo:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.sexo === "M" ? "Masculino" : "Feminino" }}</p>
                <h2 class="text-md font-semibold mt-4">Rua:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.rua ? contribuinte.rua : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Número:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.numero ? contribuinte.numero : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Complemento:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.complemento ? contribuinte.complemento : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Bairro:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.bairro ? contribuinte.bairro : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Cidade:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ contribuinte.cidade ? contribuinte.cidade : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Quantidade Total de Protocolos:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ total_prot }}</p>
                <h2 v-if="page.props.auth.user.perfil_acesso === 2" class="text-md font-semibold mt-4">Quantidade de Protocolos com Permissão para Visualizar:</h2>
                <p v-if="page.props.auth.user.perfil_acesso === 2" class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ protocolos.length }}</p>
            </section>

            <section class="px-8 py-4" v-if="opcao === 'protocolos'">
            <h1 class="font-semibold text-lg mx-auto w-fit mb-8">{{ protocolos.length ? 'Lista de Protocolos' : 'Sem Protocolos'}}</h1>
            <input type="text" v-model="filtro" placeholder="Filtrar por Descrição ou Departamento" v-if="protocolos.length" class="px-3 mt-1 mb-5 py-2 w-2/3 border rounded text-sm">
            
            <div class="border-gray-200 border bg-gray-100 p-4 rounded-md flex flex-col mb-3" v-for="protocolo in filtros">
                <div class="flex justify-between">
                    <div>
                    <h1 class="font-semibold text-lg">Protocolo # {{ protocolo.id }} </h1>
                    <p class="text-xs">{{ new Date(protocolo.created_at).toLocaleString('pt-BR') }}</p>
                    </div>
                    <div class="flex space-x-1 items-start">
                        <Link class="p-1 text-white rounded bg-yellow-500/90 hover:bg-amber-300" v-bind:href="route('protocolos-show', protocolo.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                            </svg>
                        </Link>
                        <Link class="p-1 text-white rounded bg-sky-600/90 hover:bg-blue-300" v-bind:href="route('protocolos-edit', protocolo.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                            </svg>
                        </Link>
                        <button class="p-1 text-white rounded bg-rose-600/80 hover:bg-red-300" @click="remove(protocolo)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
              <p class="mt-5">{{ protocolo.descricao }}</p>
              <div class="flex justify-between mt-8">
                <Link :href="route('departamentos-show', protocolo.departamento.id)">
                    <p><span class="font-semibold">Departamento:</span> {{ protocolo.departamento.id }} - {{ protocolo.departamento.nome }}</p>
                </Link>
                <div class="flex space-x-6">
                    <p><span class="font-semibold">Acompanhamentos:</span> {{ protocolo.acompanhamentos_count }} </p>
                    <p><span class="font-semibold">Anexos:</span> {{ protocolo.anexos_count }}</p>
                </div>
              </div>
            </div>
        </section>

        </section>
        
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Swal from 'sweetalert2';

    const opcao = ref('contribuinte');

    const page = usePage();

    let form = useForm({});

    const filtro = ref('')

    const filtros = computed(() => {
        if(filtro.value === '') {
            return props.protocolos;    
        } else {
            return props.protocolos.filter(protocolo => (protocolo.departamento.nome.toLowerCase().includes(filtro.value.toLowerCase()) || (protocolo.descricao.toLowerCase().includes(filtro.value.toLowerCase()))));
        }
    });
    

    const props = defineProps({
        contribuinte: Object,
        protocolos: Object,
        total_prot: String,
    });


    const remove = (protocolo) => {
        
        Swal.fire({
            title: 'Confirma exclusão desse Protocolo?',
                html: "<b>ID:</b> " + protocolo.id + '<br>' + "<b>Descrição:</b> " + protocolo.descricao
            + "<br><b>Departamento:</b> " + protocolo.departamento_id + " - " + protocolo.departamento.nome
            + "<br><b>Data:</b> " + new Date(protocolo.created_at).toLocaleString('pt-BR') + "<br><b>Prazo:</b> " + protocolo.prazo + " dias"
            + "<br><b>Situação:</b> " + (protocolo.situacao == 1 ? 'Concluído' : 'Pendente' ),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar!',
                })
            .then((result) => {
                if (result.isConfirmed) {
                    router.delete(route('protocolos-destroy', protocolo.id));
                    Swal.fire({
                    timer: 2500,
                    title: 'Deletado!',
                    text: 'Protocolo excluído com sucesso.',
                    icon: 'success',
                })
            }
        })
    }
</script>