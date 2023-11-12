<template>
    <Head title="Usuários - Detalhes" />

    <section class="container mt-8 mx-auto px-80">
        <div v-if="user.perfil === 2" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800"><strong>Usuário: </strong>{{ user.name }}</h1>
            <!-- <h2 class="mt-8 mb-2 font-semibold">Cadastrado em: {{ usuario.created_at }}</h2> -->
            <!-- <Link :href="route('departamentos-add-user')" class="bg-cyan-500 px-3 py-2 rounded shadow-md">Conceder Acesso</Link> -->
            <form @submit.prevent="add" class="grid gap-x-8 gap-y-4 items-center bg-white mx-2 px-2 pt-4 pb-12 rounded shadow-md">
                <div>
                    <label for="user">Adicionar Acesso à Departamento:</label>
                    <select name="user" id="user" v-model="form.departamento_id" class="px-3 mt-1 py-1 w-full border rounded">
                        <option v-for="departamento in departamentos" v-bind:value="departamento.id">{{ departamento.nome }}</option>
                    </select>
                    <button type="submit" class="mt-8 bg-blue-500 px-4 py-2 rounded font-medium text-white hover:bg-blue-300 hover:ring-2">Adicionar</button>
                </div>
            </form>
            <h2 class="mt-8 mb-2 font-semibold">Departamentos com Acesso:</h2>
            <ul>
                <li v-for="departamento in user.departamentos" class="flex justify-between py-0.5 border-b-2">
                    <p>{{ departamento.id }} - {{ departamento.nome }} </p>
                    <button @click="remove(departamento.id)" type="submit" class="ml-2 px-2 bg-red-400" v-bind="departamento.id"> Remover </button> 
                </li>
            </ul>
        </div>
        <div v-else class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800"><strong>Usuário: </strong>{{ user.name }}</h1>
            <!-- <h2 class="mt-8 mb-2 font-semibold">Cadastrado em: {{ usuario.created_at }}</h2> -->
            <!-- <Link :href="route('departamentos-add-user')" class="bg-cyan-500 px-3 py-2 rounded shadow-md">Conceder Acesso</Link> -->
            
            <h2 class="mt-8 mb-2 font-semibold">Departamentos com Acesso:</h2>
            <ul>
                <li v-for="departamento in departamentos">
                    {{ departamento.id }} - {{ departamento.nome }} 
                </li>
            </ul>
        </div>
    </section>
    <!-- {{ departamento }} -->

</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

    const page = usePage();

    const props = defineProps({
        user: Object,
        departamentos: Object,
    });

    let form = useForm({
        user_id: props.user.id,
        departamento_id: null,
    });

    let add = () => {
        form.post(route('users-add-departamento'));
    }

    let remove = (id) => {
        form.departamento_id = null,
        form.delete(route('users-remove-departamento', id));
    }

</script>