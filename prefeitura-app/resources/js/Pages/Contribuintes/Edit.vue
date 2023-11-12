<template>
    <Head title="Contribuintes - Edição" />

    <section class="container mt-8 mx-auto px-40">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Editar Contribuinte</h1>
            <div class="flex justify-center gap-x-4">
                <div class="w-full">
                    <div>
                        <label for="nome" class="block text-xs">Nome:</label>
                        <input v-model="form.nome" type="text" name="nome" id="nome" class="px-3 mt-1 py-1 w-full border rounded" maxlength="101" required @change="form.validate('nome')">
                        <div v-if="form.errors.nome" v-text="form.errors.nome" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div class="mt-4">
                        <label for="cpf" class="block text-xs">CPF:</label>
                        <input v-model="form.cpf" v-mask="['###.###.###-##']" type="text" name="cpf" id="cpf" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('cpf')">
                        <div v-if="form.errors.cpf" v-text="form.errors.cpf" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div class="mt-4">
                        <label for="data_nascimento" class="block text-xs">Data de Nascimento:</label>
                        <input v-model="form.data_nascimento" type="date" name="data_nascimento" id="data_nascimento" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('data_nascimento')">
                        <div v-if="form.errors.data_nascimento" v-text="form.errors.data_nascimento" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div class="mt-4 text-xs">
                        <p>Sexo:</p>
                        <div class="flex gap-4 mt-2">
                            <div>
                                <input v-model="form.sexo" class="align-middle mr-1" type="radio" id="feminino" name="sexo" value="F" required>
                                <label class="align-bottom" for="feminino">Feminino</label>
                            </div>
                            <div>
                                <input v-model="form.sexo" class="align-middle mr-1" type="radio" id="masculino" name="sexo" value="M" required>
                                <label class="align-bottom" for="masculino">Masculino</label>
                            </div>  
                        </div>
                        <!-- <div v-if="errors.sexo" v-text="errors.sexo" class="text-red-400 text-xs mt-1.5"></div> -->
                    </div>
                </div>
                <div class="w-full">
                    <div class="flex justify-between gap-2">
                        <div class="w-10/12">
                            <label for="rua" class="block text-xs">Rua:</label>
                            <input v-model="form.rua" type="text" name="rua" id="rua" class="px-3 mt-1 py-1 w-full border rounded" maxlength="101" @change="form.validate('rua')">
                            <div v-if="form.errors.rua" v-text="form.errors.rua" class="text-red-400 text-xs mt-1.5"></div>
                        </div>
                        <div class="w-1/3">
                            <label for="numero" class="block text-xs">Número:</label>
                            <input v-model="form.numero" type="number" name="numero" id="numero" class="px-3 mt-1 py-1 w-full border rounded">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="cidade" class="block text-xs">Cidade:</label>
                        <input v-model="form.cidade" type="text" name="cidade" id="cidade" class="px-3 mt-1 py-1 w-full border rounded" maxlength="101" @change="form.validate('cidade')">
                        <div v-if="form.errors.cidade" v-text="form.errors.cidade" class="text-red-400 text-xs mt-1.5"></div>
                    </div>
                    <div class="mt-4">
                        <label for="bairro" class="block text-xs">Bairro:</label>
                        <input v-model="form.bairro" type="text" name="bairro" id="bairro" class="px-3 mt-1 py-1 w-full border rounded" maxlength="101" @change="form.validate('bairro')">
                        <div v-if="form.errors.bairro" v-text="form.errors.bairro" class="text-red-400 text-xs mt-1.5"></div>
                    </div>
                    <div class="mt-4">
                        <label for="complemento" class="block text-xs">Complemento:</label>
                        <input v-model="form.complemento" type="text" name="complemento" id="complemento" class="px-3 mt-1 py-1 w-full border rounded" maxlength="101" @change="form.validate('complemento')">
                        <div v-if="form.errors.complemento" v-text="form.errors.complemento" class="text-red-400 text-xs mt-1.5"></div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <Link v-bind:href="(route('contribuintes-index'))" class="mt-8 px-4 py-2 rounded font-medium bg-rose-600/80 text-white hover:bg-red-400">Cancelar</Link>
                <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400" :disabled="form.processing">Salvar Alterações</button>
            </div>
        </form>
    </section>  
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';

    const props = defineProps({
        contribuinte: Object
    });
    
    const form = useForm('put', route('contribuintes-update', props.contribuinte.id), {
        id: props.contribuinte.id,
        nome: props.contribuinte.nome,
        cpf: props.contribuinte.cpf,
        data_nascimento: props.contribuinte.data_nascimento,
        sexo: props.contribuinte.sexo,
        cidade: props.contribuinte.cidade,
        bairro: props.contribuinte.bairro,
        rua: props.contribuinte.rua,
        numero: props.contribuinte.numero,
        complemento: props.contribuinte.complemento,
    });

    const submit = () => form.submit();
</script>

<script>
import {mask} from 'vue-the-mask'
    export default {
    directives: {mask}
    }
</script>