<template>
    <Head title="Usuários - Cadastro" />

    <section class="container mt-8 mx-auto px-80">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Cadastrar Usuário</h1>
            <div>
                <label for="name" class="block text-xs">Nome:</label>
                <input v-model="form.name" type="text" name="name" id="name" class="px-3 mt-1 py-1 w-full border rounded" required>
                <div v-if="page.props.errors.name" v-text="page.props.errors.name" class="text-red-400 text-xs mt-1"></div>
            </div>
            <div class="mt-4">
                <label for="email" class="block text-xs">Email:</label>
                <input v-model="form.email" type="email" name="email" id="email" class="px-3 mt-1 py-1 w-full border rounded" required>
                <div v-if="page.props.errors.email" v-text="page.props.errors.email" class="text-red-400 text-xs mt-1"></div>
            </div>
            <div class="mt-4">
                <label for="cpf" class="block text-xs">CPF:</label>
                <input v-model="form.cpf" type="text" name="cpf" id="cpf" class="px-3 mt-1 py-1 w-full border rounded" required>
                <div v-if="page.props.errors.cpf" v-text="page.props.errors.cpf" class="text-red-400 text-xs mt-1"></div>
            </div>
            <div class="mt-4">
                <label for="password" class="block text-xs">Senha:</label>
                <input v-model="form.password" type="password" name="password" id="password" class="px-3 mt-1 py-1 w-full border rounded" required>
                <div v-if="page.props.errors.password" v-text="page.props.errors.password" class="text-red-400 text-xs mt-1"></div>
            </div>
            <div class="mt-4 text-xs">
                <p>Perfil de Acesso:</p>
                <div class="flex justify-between mt-2">
                    <div v-if="perfil_acesso === 0">
                        <input v-model="form.perfil" class="align-middle mr-1" type="radio" id="admin-ti" name="perfil" value="0" required>
                        <label class="align-bottom" for="admin-ti">Administrador TI</label>
                    </div>
                    <div v-if="perfil_acesso === 0">
                        <input v-model="form.perfil" class="align-middle mr-1" type="radio" id="admin-sistema" name="perfil" value="1" required>
                        <label class="align-bottom" for="admin-sistema">Administrador Sistema</label>
                    </div>
                    <div>
                        <input v-model="form.perfil" v-bind:checked="perfil_acesso === 1" class="align-middle mr-1" type="radio" id="operador" name="perfil" value="2" required>
                        <label class="align-bottom" for="operador">Operador</label>
                    </div>  
                </div>
                <div v-if="page.props.errors.perfil" v-text="page.props.errors.perfil" class="text-red-400 text-xs mt-1.5"></div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <Link v-bind:href="(route('users-index'))" class="mt-8 px-4 py-2 rounded font-medium bg-rose-600/80 text-white hover:bg-red-400">Cancelar</Link>
                <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400">Cadastrar</button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';    
import { computed } from 'vue';

    let form = useForm({
        name: '',
        email: '',
        cpf: '',
        password: '',
        perfil: '',
    });

    let submit = () => {
        form.post(route('users-store'));
    };

    const page = usePage();
    const perfil_acesso = computed(() => page.props.auth.user.perfil_acesso);
</script>