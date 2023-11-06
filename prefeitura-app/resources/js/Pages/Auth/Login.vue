<template>
    <main>

        <section class="min-h-screen grid place-items-center">

            <form @submit.prevent="submit" method="post" class="mb-20 mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
                <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Login</h1>
                <div class="flex flex-col">
                    <label for="cpf" class="text-xs">CPF:</label>
                    <input v-model="form.cpf" v-mask="['###.###.###-##']" type="text" name="cpf" id="cpf" class="px-3 mt-1 mb-4 py-1 w-full border rounded" required>
                    <div v-if="form.errors.cpf" v-text="form.errors.cpf"></div>
                </div>
                <div class="flex flex-col">
                    <label for="senha" class="text-xs">Senha:</label>
                    <input v-model="form.password" name="password" id="password" type="password" class="px-3 mt-1 mb-4 py-1 w-full border rounded" required>
                    <div v-if="form.errors.password" v-text="form.errors.password"></div>
                </div>
                <div>
                    <button type="submit" class="bg-sky-500/90 px-4 py-2 rounded hover:ring-2 hover:bg-blue-300">Log In</button>
                </div>
            </form>

        </section>

    </main>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';

    let form = useForm({
        cpf: '',
        password: ''
    });

    let submit = () => {
        form.post('/login');
    };
</script>

<script>
import {mask} from 'vue-the-mask'
    export default {
        layout: null,
        directives: {mask}
    }
</script>