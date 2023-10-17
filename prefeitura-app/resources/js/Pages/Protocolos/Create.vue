<template>
    <section class="container mt-8 mx-auto px-40">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Cadastrar Protocolo</h1>
            <div class="flex flex-col justify-center gap-x-4">
                <div class="grid grid-cols-2 gap-4 w-full">
                    <div>
                        <label for="contribuinte">Contribuinte:</label>
                            <select name="contribuinte" id="contribuinte" v-model="form.contribuinte_id" required>
                                <option v-for="contribuinte in contribuintes" v-bind:value="contribuinte.id">{{ contribuinte.nome }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="departamento">Departamento:</label>
                            <select name="departamento" id="departamento" v-model="form.departamento_id" required>
                                <option v-for="departamento in departamentos" v-bind:value="departamento.id">{{ departamento.nome }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="descricao" class="block text-xs">Descricao:</label>
                        <input v-model="form.descricao" type="text" name="descricao" id="descricao" class="px-3 mt-1 py-1 w-full border rounded" required>
                    </div>
                    <div>
                        <label for="prazo" class="block text-xs">Prazo:</label>
                        <input v-model="form.prazo" type="number" name="prazo" id="prazo" class="px-3 mt-1 py-1 w-full border rounded" required>
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

    const props = defineProps({
        departamentos: Object,
        contribuintes: Object,
    });

    let form = useForm({
        contribuinte_id: null,
        departamento_id: null,
        descricao: '',
        prazo: '',
    });

    let submit = () => {
        form.post(route('protocolos-store'));
    }
</script>