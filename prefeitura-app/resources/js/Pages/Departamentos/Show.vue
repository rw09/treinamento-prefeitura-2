<template>
    <Head title="Departamentos - Detalhes" />

    <section class="container mt-8 mx-auto px-80">
        <div class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800"><strong>Departamento: </strong>{{ departamento.nome }}</h1>
            <h2 class="mt-8 mb-2 font-semibold">Criado em: {{ departamento.created_at }}</h2>
            <!-- <Link :href="route('departamentos-add-user')" class="bg-cyan-500 px-3 py-2 rounded shadow-md">Conceder Acesso</Link> -->
            <form @submit.prevent="form.post(route('departamentos-add-user'))" class="grid grid-cols-2 gap-x-8 gap-y-4 items-center bg-white mx-2 px-2 pt-4 pb-12 rounded shadow-md">
                <div>
                    <label for="user">Adicionar Usuários:</label>
                    <select name="user" id="user" v-model="form.user_id">
                        <option v-for="user in users" v-bind:value="user.id">{{ user.name }}</option>
                    </select>
                    <button @click="add" type="submit" class="mt-8 bg-blue-500 px-4 py-2 rounded font-medium text-white hover:bg-blue-300 hover:ring-2">Adicionar</button>
                </div>
            </form>
            <h2 class="mt-8 mb-2 font-semibold">Operadores com Acesso:</h2>
            <ul>
                <li class="w-32" v-for="user in departamento.users">{{ user.id }} - {{ user.name }}</li>
            </ul>
        </div>
    </section>
    <!-- {{ departamento }} -->

</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        departamento: Object,
        users: Object,
    });

    let form = useForm({
        departamento_id: props.departamento.id,
        user_id: null,
    });

    let add = () => {
        form.post(route('departamentos-add-user'));
    }

</script>