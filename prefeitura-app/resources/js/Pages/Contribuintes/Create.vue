<template>
    <Head title="Contribuintes - Cadastro" />

    <section class="container mt-8 mx-auto px-40">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Cadastrar Contribuinte</h1>
            <div class="flex flex-col justify-center gap-x-4">
                <div class="grid grid-cols-2 gap-4 w-full">
                    <div>
                        <label for="nome" class="block text-xs">Nome:</label>
                        <input v-model="form.nome" type="text" name="nome" id="nome" class="px-3 mt-1 py-1 w-full border rounded">
                    </div>
                    <div>
                        <label for="cpf" class="block text-xs">CPF:</label>
                        <input v-model="form.cpf" type="text" name="cpf" id="cpf" class="px-3 mt-1 py-1 w-full border rounded">
                    </div>
                    <div>
                        <label for="data_nascimento" class="block text-xs">Data de Nascimento:</label>
                        <input v-model="form.data_nascimento" type="date" name="data_nascimento" id="data_nascimento" class="px-3 mt-1 py-1 w-full border rounded">
                    </div>
                    <div class="text-xs">
                        <p>Sexo:</p>
                        <div class="flex gap-4 mt-2">
                            <div>
                                <input v-model="form.sexo" class="align-middle mr-1" type="radio" id="feminino" name="feminino" value="F">
                                <label class="align-bottom" for="feminino">Feminino</label>
                            </div>
                            <div>
                                <input v-model="form.sexo" class="align-middle mr-1" type="radio" id="masculino" name="masculino" value="M">
                                <label class="align-bottom" for="masculino">Masculino</label>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-10 gap-4 w-full">
                    <div>
                        <label for="rua" class="block text-xs">Rua:</label>
                        <input v-model="form.rua" type="text" name="rua" id="rua" class="px-3 mt-1 py-1 w-full border rounded">
                    </div>
                    <div class="flex justify-between gap-2">
                        <div class="w-1/3">
                            <label for="numero" class="block text-xs">Número:</label>
                            <input v-model="form.numero" type="number" name="numero" id="numero" class="px-3 mt-1 py-1 w-full border rounded">
                        </div>
                        <div class="w-10/12">
                            <label for="Complemento" class="block text-xs">Complemento:</label>
                            <input v-model="form.complemento" type="text" name="complemento" id="complemento" class="px-3 mt-1 py-1 w-full border rounded">
                        </div>
                    </div>
                    <div>
                        <label for="bairro" class="block text-xs">Bairro:</label>
                        <input v-model="form.bairro" type="text" name="bairro" id="bairro" class="px-3 mt-1 py-1 w-full border rounded">
                    </div>
                    <div>
                        <label for="cidade" class="block text-xs">Cidade:</label>
                        <input v-model="form.cidade" type="text" name="cidade" id="cidade" class="px-3 mt-1 py-1 w-full border rounded">
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <Link v-bind:href="(route('contribuintes-index'))" class="mt-8 px-4 py-2 rounded font-medium bg-rose-600/80 text-white hover:bg-red-400">Cancelar</Link>
                <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400">Cadastrar</button>
            </div>
        </form>
    </section>  
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

    let form = useForm({
        nome: '',
        cpf: '',
        data_nascimento: '',
        sexo: '',
        cidade: '',
        bairro: '',
        rua: '',
        numero: '',
        complemento: '',
    });

    let submit = () => {
        form.post(route('contribuintes-store'));
    };
</script>