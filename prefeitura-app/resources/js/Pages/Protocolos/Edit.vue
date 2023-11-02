<template>
    <section class="container mt-8 mx-auto px-40">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Editar Protocolo</h1>
            <div class="flex flex-col justify-center gap-x-4">
                <div class="grid grid-cols-2 gap-4 w-full">
                    <div>
                        <label for="numero" class="block text-xs">Número:</label>
                        <input v-model="form.id" type="number" name="numero" id="numero" class="px-3 mt-1 py-1 w-full border rounded bg-gray-200" readonly>
                    </div>
                    <div>
                        <label for="data" class="block text-xs">Data:</label>
                        <input v-model="form.data_protocolo" type="text" name="data" id="data" class="px-3 mt-1 py-1 w-full border rounded bg-gray-200" readonly>
                    </div>
                    <div>
                        <label for="contribuinte" class="text-xs">Contribuinte:</label>
                        <select name="contribuinte" id="contribuinte" v-model="form.contribuinte_id" class="px-3 mt-1 py-1 w-full border rounded" required>
                            <option v-for="contribuinte in contribuintes" v-bind:value="contribuinte.id">{{ contribuinte.nome }}</option>
                        </select>
                        <div v-if="form.errors.contribuinte_id" v-text="form.errors.contribuinte_id" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div>
                        <label for="departamento" class="text-xs">Departamento:</label>
                        <select name="departamento" id="departamento" v-model="form.departamento_id" class="px-3 mt-1 py-1 w-full border rounded" required>
                            <option v-for="departamento in departamentos" v-bind:value="departamento.id">{{ departamento.nome }}</option>
                        </select>
                        <div v-if="form.errors.departamento_id" v-text="form.errors.departamento_id" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div>
                        <label for="descricao" class="block text-xs">Descricao:</label>
                        <input v-model="form.descricao" type="text" name="descricao" id="descricao" class="px-3 mt-1 py-1 w-full border rounded" required>
                        <div v-if="form.errors.descricao" v-text="form.errors.descricao" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div>
                        <label for="prazo" class="block text-xs">Prazo:</label>
                        <input v-model="form.prazo" type="number" name="prazo" id="prazo" class="px-3 mt-1 py-1 w-full border rounded" required>
                        <div v-if="form.errors.prazo" v-text="form.errors.prazo" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div class="text-xs">
                        <p>Situação:</p>
                        <div class="flex gap-4 mt-2">
                            <div>
                                <input v-model="form.situacao" class="align-middle mr-1" type="radio" id="pendente" name="situacao" value="0" required>
                                <label class="align-bottom" for="pendente">Pendente</label>
                            </div>
                            <div>
                                <input v-model="form.situacao" class="align-middle mr-1" type="radio" id="concluido" name="situacao" value="1" required>
                                <label class="align-bottom" for="concluido">Concluído</label>
                            </div>  
                        </div>
                        <div v-if="form.errors.situacao" v-text="form.errors.situacao" class="text-red-400 text-xs mt-1.5"></div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <Link @click="back" class="mt-8 px-4 py-2 rounded font-medium bg-rose-600/80 text-white hover:bg-red-400">Cancelar</Link>
                <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400" :disabled="form.processing">Salvar Alterações</button>
            </div>
        </form>
    </section>  
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        protocolo: Object,
        departamentos: Object,
        contribuintes: Object
    });

    let form = useForm({
        id: props.protocolo.id,
        data_protocolo: new Date(props.protocolo.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}),
        contribuinte_id: props.protocolo.contribuinte_id,
        departamento_id: props.protocolo.departamento_id,
        descricao: props.protocolo.descricao,
        situacao: props.protocolo.situacao,
        prazo: props.protocolo.prazo,
    });

    let submit = () => {
        form.put(route('protocolos-update', form.id));
    }

    let back = () => {
        history.back();
    }
</script>