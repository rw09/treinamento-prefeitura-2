<template>
    <Head title="Usuários - Detalhes" />

    <section class="sm:mx-10 lg:mx-80 space-y-4 shadow-md pb-8 mb-6 rounded-md border">
            <nav class="flex bg-gray-200 mb-6">
                <label for="opcao-user" class="py-3.5 px-4 cursor-pointer hover:bg-white hover:rounded-tl" v-bind:class="{'bg-gray-50 rounded-tl font-semibold' : opcao === 'user'}">
                    <input type="radio" value="user" id="opcao-user" name="opcao" v-model="opcao" class="hidden">Usuário
                </label>
                <label for="opcao-departamentos" class="py-3.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-gray-50 font-semibold' : opcao === 'departamentos'}">
                    <input type="radio" value="departamentos" id="opcao-departamentos" name="opcao" v-model="opcao" class="hidden">
                        Departamentos
                </label>
            </nav>

            <section class="px-8 py-4" v-if="opcao === 'user'">
                <h1 class="font-semibold text-lg mx-auto w-fit mb-4">Usuário # {{ user.id }}</h1>
                <h2 class="text-md font-semibold mt-4">Nome:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ user.name }}</p>
                <h2 class="text-md font-semibold mt-4">CPF:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ user.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') }}</p>
                <h2 class="text-md font-semibold mt-4">E-mail:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ user.email }}</p>
                <h2 class="text-md font-semibold mt-4">Perfil de Acesso:</h2>
                <p class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ user.perfil }} - {{ (user.perfil === 0 ? "Administrador do Sistema" : (user.perfil === 1 ? "Administrador da TI" : "Operador")) }}</p>
                <h2 v-if="user.perfil === 2" class="text-md font-semibold mt-4">Quantidade Total de Departamentos:</h2>
                <p v-if="user.perfil === 2" class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ user.perfil === 2 ? (user.departamentos.length + departamentos.length) : departamentos.length }}</p>
                <h2 v-if="user.perfil === 2" class="text-md font-semibold mt-4">Quantidade Departamentos com Acesso:</h2>
                <p v-if="user.perfil === 2" class="border-gray-200 border bg-gray-100 p-2.5 rounded">{{ user.departamentos.length }}</p>
            </section>

            <section class="px-8 py-4" v-if="opcao === 'departamentos'">
            <h1 class="font-semibold text-lg mx-auto w-fit mb-8">{{ user.perfil != 2 ? 'Lista de Departamentos' : (user.departamentos.length ? 'Lista de Departamentos' : 'Sem Departamentos') }}</h1>
            <div class="flex items-center mt-1 mb-5" v-if="props.departamentos.length && user.perfil == 2">
                <form @submit.prevent="add" class="flex w-full justify-between items-center">
                    <div class="w-3/4">
                        <select name="user" id="user" v-model="form.departamento_id" class="px-4 py-1 border rounded">
                            <option value="null" disabled selected hidden>Adicionar Acesso à Departamento:</option>
                            <option v-for="departamento in props.departamentos" v-bind:value="departamento.id">{{ departamento.nome }}</option>
                        </select>
                    </div>
                    <div class="self-end">
                        <button type="submit" class="px-4 py-2 ml-5 rounded-sm text-sm text-white text-center" :disabled="form.departamento_id == null" v-bind:class="form.departamento_id != null ? 'bg-teal-500 hover:bg-teal-400' : 'bg-gray-300'">Conceder Acesso</button>
                    </div>
                </form>
            </div>
            
            <div class="border-gray-200 border bg-gray-100 p-4 rounded-md flex flex-col mb-3" v-for="departamento in (user.perfil == 2 ? props.departamentos_usuario : props.departamentos)">
                <div class="flex justify-between">
                    <div>
                    <h1 class="font-semibold text-lg">Departamento # {{ departamento.id }} - {{  departamento.nome }}</h1>
                    <p class="text-xs">{{ new Date(departamento.created_at).toLocaleString('pt-BR') }}</p>
                    </div>
                    <div class="flex space-x-1 items-start">
                        <Link class="p-1 text-white rounded bg-yellow-500/90 hover:bg-amber-300" v-bind:href="route('departamentos-show', departamento.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                            </svg>
                        </Link>
                        <Link class="p-1 text-white rounded bg-sky-600/90 hover:bg-blue-300" v-bind:href="route('departamentos-edit', departamento.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                            </svg>
                        </Link>
                        <button class="p-1 text-white rounded bg-rose-600/80 hover:bg-red-300" @click="excluir(departamento)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-5 flex space-x-5">
                    <p><span class="font-semibold">Total de Protocolos: </span> {{ departamento.protocolos_count }} </p>
                    <!-- <p><span class="font-semibold">Usuários: </span> {{ departamento.users_count }}</p> -->
                </div>
              <div class="mt-5 flex justify-between">
                <p><span class="font-semibold">Total de Usuários: </span> {{ departamento.users_count }}</p>
                <button v-if="user.perfil == 2" class="px-3 py-1.5 text-white rounded bg-rose-600/80 hover:bg-red-300" @click="remove(departamento)">
                    Remover Acesso
                </button>
              </div>
            </div>
        </section>
    </section>

</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';

    const opcao = ref('user');

    const page = usePage();

    const props = defineProps({
        user: Object,
        departamentos: Object,
        departamentos_usuario: Object,
    });

    let form = useForm({
        user_id: props.user.id,
        departamento_id: null,
    });

    let add = () => {
        form.post(route('users-add-departamento'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {[
                Swal.fire({
                    title: 'Sucesso!',
                    html: page.props.flash.message,
                    timer: 2500,
                    icon: 'success',
                }),  
            ]},
        }),
        form.departamento_id = null
    }

    let remove = (id) => {
        form.departamento_id = null,
        form.delete(route('users-remove-departamento', id), {
            onSuccess: () => {[
                Swal.fire({
                        title: 'Sucesso!',
                        html: page.props.flash.message,
                        timer: 2500,
                        icon: 'success',
                    }),  
                ]},
        });
    }

    let excluir = (departamento) => {
        Swal.fire({
            title: 'Confirma exclusão desse Departamento?',
            html: "<b>ID:</b> " + departamento.id + '<br>' + '<b>Nome:</b> ' + departamento.nome,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar!',
            })
        .then((result) => {
            if (result.isConfirmed) {
                form.delete(route('departamentos-destroy', departamento.id));
                Swal.fire({
                    timer: 2500,
                    title: 'Deletado!',
                    text: 'Departamento removido com sucesso.',
                    icon: 'success',
                })
            }
        })
    };

</script>