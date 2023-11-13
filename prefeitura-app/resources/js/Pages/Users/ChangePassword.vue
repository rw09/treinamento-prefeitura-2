<template>
    <Head title="Alterar Senha" />

    <section class="container mt-8 mx-auto px-80">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Alterar Senha</h1>
            <div>
                <label for="senha_velha" class="block text-xs">Senha Atual:</label>
                <input v-model="form.senha_velha" type="password" name="senha_velha" id="senha_velha" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('senha_velha')">
                <div v-if="form.errors.senha_velha" v-text="form.errors.senha_velha" class="text-red-400 text-xs mt-1"></div>
                
                <label for="nova_senha" class="block text-xs">Nova Senha:</label>
                <input v-model="form.nova_senha" type="password" name="nova_senha" id="nova_senha" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('nova_senha')">
                <div v-if="form.errors.nova_senha" v-text="form.errors.nova_senha" class="text-red-400 text-xs mt-1"></div>
                
                <label for="confirmacao" class="block text-xs">Cofirme a Senha:</label>
                <input v-model="form.confirmacao" type="password" name="confirmacao" id="confirmacao" class="px-3 mt-1 py-1 w-full border rounded"  required @change="form.validate('confirmacao')">
                <div v-if="form.errors.confirmacao" v-text="form.errors.confirmacao" class="text-red-400 text-xs mt-1"></div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <Link v-bind:href="(route('home'))" class="mt-8 px-4 py-2 rounded font-medium bg-rose-600/80 text-white hover:bg-red-400">Cancelar</Link>
                <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400" :disabled="form.processing">Salvar Alterações</button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import { usePage } from '@inertiajs/vue3';

    const page = usePage();

    const props = defineProps();

    const form = useForm('post', route('user-update-password'), {
        senha_velha: null,
        nova_senha: null,
        confirmacao: null,
    });

    const submit = () => form.submit();
</script>