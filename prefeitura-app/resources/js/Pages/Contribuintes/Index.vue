<template>
    <Head title="Contribuintes - Listagem" />

    <section class="container mt-6 mx-auto shadow-md">
        <div class="flex justify-between items-center p-2 bg-gray-200">
            <form class="flex w-1/3">
                <input v-model="pesquisa" class="h-7 px-2 text-xs" type="search" name="pesquisa" id="pesquisa" placeholder="Pesquise por nome">
            </form>
            <Link v-bind:href="route('contribuintes-create')" class="py-1.5 px-3 rounded shadow-md text-sm text-white bg-teal-500 hover:bg-teal-400">
                Cadastrar
            </Link>
        </div>
    </section>

    <section class="container mt-4 mb-10 mx-auto shadow-sm text-xs">
        <table class="table-auto w-full">
            <thead class="text-left border-b-2 bordar-gray-300 shadow-sm bg-gray-200">
                <tr class="border-b-2 border-b-gray-300">
                    <th class="py-1.5">ID</th>
                    <th>Nome</th>
                    <th class="text-center">Data Nascimento</th>
                    <th class="text-center">CPF</th>
                    <th class="text-center">Sexo</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr v-for="contribuinte in contribuintes.data" v-bind="contribuinte.id" class="hover:bg-slate-200">
                    <td>{{ contribuinte.id }}</td>
                    <td>{{ contribuinte.nome }}</td>
                    <td class="text-center">{{ new Date(contribuinte.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) }}</td>
                    <td class="text-center">{{ contribuinte.cpf }}</td>
                    <td class="text-center">{{ contribuinte.sexo }}</td>
                    <!-- <td>{{ contribuinte.rua }} {{ contribuinte.numero ? contribuinte.numero : " s/nº " }} {{ contribuinte.complemento ? " - " + contribuinte.complemento : "" }}</td> -->
                    <td>
                        {{ contribuinte.rua ? (contribuinte.rua + ", " + (contribuinte.numero ? contribuinte.numero : "s/nº") + (contribuinte.complemento ? " - " + contribuinte.complemento : "")) : "" }}
                    </td>
                    <td>{{ contribuinte.bairro }}</td>
                    <td>{{ contribuinte.cidade }}</td>
                    <td class="flex justify-center items-center space-x-1 py-0.5">
                        <Link v-bind:href="(route('contribuintes-show', contribuinte.id))">
                        <div class="p-1 text-white rounded bg-yellow-500/90 hover:bg-amber-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </Link>
                        <Link v-bind:href="(route('contribuintes-edit', contribuinte.id))">
                            <div class="p-1 text-white rounded bg-sky-600/90 hover:bg-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </div>
                        </Link>
                        <button @click="destroy(contribuinte.id)" class="p-1 text-white rounded bg-rose-600/80 hover:bg-red-300">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" fill="currentColor" class="w-3.5 h-3.5" viewBox="0 0 26 26">
                                <path d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <section class="container mx-auto" v-if="contribuintes.last_page > 1">
        <Pagination v-bind:links="contribuintes.links" class="text-xs"/>
    </section>
    <div v-if="contribuintes.data.length === 0" class="container mx-auto flex justify-center">
        <h2 class="text-sm">Nenhum Contribuinte</h2>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import Pagination from '../../Shared/Pagination.vue';

    const props = defineProps({contribuintes: Object});

    let destroy = (id) => { //depois trocar por um modal!
        if (confirm('Are you sure?')){
            router.delete(route('contribuintes-destroy', id));
        }
    };
</script>