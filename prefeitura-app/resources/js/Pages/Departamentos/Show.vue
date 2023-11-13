<template>
    <Head title="Departamento Detalhes" />
    
    <section class="sm:mx-10 lg:mx-80 space-y-4 shadow-md pb-8 mb-6 rounded-md border">
            <nav class="flex bg-gray-200 mb-6">
                <label for="opcao-departamento" class="py-3.5 px-4 cursor-pointer hover:bg-white hover:rounded-tl" v-bind:class="{'bg-gray-50 rounded-tl font-semibold' : opcao === 'departamento'}">
                    <input type="radio" value="departamento" id="opcao-departamento" name="opcao" v-model="opcao" class="hidden">Departamento
                </label>
                <label for="opcao-users" class="py-3.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-gray-50 font-semibold' : opcao === 'users'}">
                    <input type="radio" value="users" id="opcao-users" name="opcao" v-model="opcao" class="hidden">Usuários
                </label>
                <label for="opcao-protocolos" class="py-3.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-gray-50 font-semibold' : opcao === 'protocolos'}">
                    <input type="radio" value="protocolos" id="opcao-protocolos" name="opcao" v-model="opcao" class="hidden">Protocolos
                </label>
            </nav>

            <section class="px-8 py-4" v-if="opcao === 'departamento'">
                <h1 class="font-semibold text-lg mx-auto w-fit mb-4">Departamento # {{ departamento.id }}</h1>
                <h2 class="text-md font-semibold mt-4">Nome:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ departamento.nome }}</p>
                <h2 class="text-md font-semibold mt-4">Total de Protocolos:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ departamento.protocolos_count }}</p>
                <h2 class="text-md font-semibold mt-4">Total de Usuários:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ departamento.users_count }}</p>
            </section>

            <section class="px-8 py-4" v-if="opcao === 'users'">
                <h1 class="font-semibold text-lg mx-auto w-fit mb-8">{{ departamento.users_count > 0 ? 'Lista de Usuários' : 'Sem Usuários' }}</h1>
                <div class="flex items-center mt-1 mb-5" v-if="users.length">
                    <form @submit.prevent="addUser" class="flex w-full justify-between items-center">
                        <div class="w-3/4">
                            <select name="user" id="user" v-model="form.user_id" class="px-4 py-1 border rounded">
                                <option value="null" disabled selected hidden>Adicionar Acesso à Usuário:</option>
                                <option v-for="user in props.users" v-bind:value="user.id">{{ user.name }}</option>
                            </select>
                        </div>
                        <div class="self-end">
                            <button type="submit" class="px-4 py-2 ml-5 rounded-sm text-sm text-white text-center" :disabled="form.user_id == null" v-bind:class="form.user_id != null ? 'bg-teal-500 hover:bg-teal-400' : 'bg-gray-300'">Conceder Acesso</button>
                        </div>
                    </form>
                </div>
                
                <div class="border-gray-200 border bg-gray-100 p-4 rounded-md flex flex-col mb-3" v-for="user in props.departamento.users">
                    <div class="flex justify-between">
                        <div>
                            <h1 class="font-semibold text-lg">Usuário # {{ user.id }} - {{  user.name }}</h1>
                            <p class="text-xs">{{ new Date(user.created_at).toLocaleString('pt-BR') }}</p>
                        </div>
                        <div class="flex space-x-1 items-start">
                            <Link class="p-1 text-white rounded bg-yellow-500/90 hover:bg-amber-300" v-bind:href="route('users-show', user.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                </svg>
                            </Link>
                            <Link class="p-1 text-white rounded bg-sky-600/90 hover:bg-blue-300" v-bind:href="route('users-edit', user.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                    <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                                </svg>
                            </Link>
                            <button class="p-1 text-white rounded bg-rose-600/80 hover:bg-red-300" @click="excluir(user)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-5 flex space-x-5">
                        <p><span>CPF: </span> {{ user.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') }} </p>
                    </div>
                    <div class="mt-5 flex justify-between">
                        <p><span>E-mail: </span> {{ user.email }}</p>
                        <button class="px-3 py-1.5 text-white rounded bg-rose-600/80 hover:bg-red-300" @click="removeUser(user.id)">
                            Remover Acesso
                        </button>
                    </div>
                </div>
            </section>
        
    
            <section class="px-8 py-4" v-if="opcao === 'protocolos'">
                <h1 class="font-semibold text-lg mx-auto w-fit mb-8">{{ protocolos.length ? 'Lista de Protocolos' : 'Sem Protocolos'}}</h1>
                <div class="flex items-center mt-1 mb-5">
                    <Link v-bind:href="route('protocolos-create-by-departamento', departamento.id)" class="px-4 py-2 w-1/4 mr-5 rounded-sm text-sm text-white bg-teal-500 hover:bg-teal-400 text-center">Cadastrar Protocolo</Link>
                    <input type="search" id="filtragem" v-model="filtro" placeholder="Filtrar por Descrição ou Contribuinte" v-if="protocolos.length" class="px-4 py-1.5 w-2/3 border rounded text-sm">
                </div>
                
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
                            <button class="p-1 text-white rounded bg-rose-600/80 hover:bg-red-300" @click="excluirProtocolo(protocolo)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                <p class="mt-5">{{ protocolo.descricao }}</p>
                <div class="flex justify-between mt-8">
                    <Link :href="route('contribuintes-show', protocolo.contribuinte.id)">
                        <p><span class="font-semibold">Contribuinte:</span> {{ protocolo.contribuinte.id }} - {{ protocolo.contribuinte.nome }}</p>
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
import { useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Swal from 'sweetalert2';
import { usePage } from '@inertiajs/vue3';

    const opcao = ref('departamento');

    let page = usePage();

    const filtro = ref('')

    const filtros = computed(() => {
        if(filtro.value === '') {
            return props.protocolos;    
        } else {
            return props.protocolos.filter(protocolo => (protocolo.contribuinte.nome.toLowerCase().includes(filtro.value.toLowerCase()) || (protocolo.descricao.toLowerCase().includes(filtro.value.toLowerCase()))));
        }
    });

    const props = defineProps({
        departamento: Object,
        protocolos: Object,
        users: Object
    });

    
    let form = useForm({
        departamento_id: props.departamento.id,
        user_id: null,
    });
    

    let addUser = () => {
        form.post(route('departamentos-add-user'), {
            onSuccess: () => {
                Swal.fire({
                    title: 'Acesso Concedido com Sucesso!',
                    html: page.props.flash.message,
                    timer: 2500,
                    icon: 'success',
                })  
            }
        }),
        form.user_id = null
    };

    let removeUser = (id) => {
        form.user_id = null,
        form.delete(route('departamentos-remove-user', id), {
            onSuccess: () => {
                Swal.fire({
                    title: 'Acesso Removido com Sucesso!',
                    html: page.props.flash.message,
                    timer: 4000,
                    icon: 'success',
                })  
            }
        });
    };

    const excluirProtocolo = (protocolo) => {
        
        Swal.fire({
            title: 'Confirma exclusão desse Protocolo?',
                html: "<b>ID:</b> " + protocolo.id + '<br>' + "<b>Descrição:</b> " + protocolo.descricao
            + "<br><b>Contribuinte:</b> " + protocolo.contribuinte.id + " - " + protocolo.contribuinte.nome
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