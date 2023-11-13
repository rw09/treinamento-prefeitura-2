<template>
    <Head title="Acompanhamento - Edição" />

    <section class="container mt-8 mx-auto px-80">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Editar Acompanhamento</h1>
            <div>
                <label for="observacao" class="block text-xs">Observação:</label>
                <textarea v-model="form.observacao" type="text" name="observacao" id="observacao" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('observacao')"></textarea>
                <div v-if="form.errors.observacao" v-text="form.errors.observacao" class="text-red-400 text-xs mt-1"></div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <Link v-bind:href="(route('protocolos-index'))" class="mt-8 px-4 py-2 rounded font-medium bg-rose-600/80 text-white hover:bg-red-400">Cancelar</Link>
                <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400" :disabled="form.processing">Salvar Alterações</button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';

    const props = defineProps({
        acompanhamento: Object
    });

    const form = useForm('put', route('acompanhamentos-update', props.acompanhamento.id), {
        id: props.acompanhamento.id,
        observacao: props.acompanhamento.observacao,
        user_id: props.acompanhamento.user_id,
        protocolo_id: props.acompanhamento.protocolo_id,
    });

    const submit = () => form.submit();
</script>