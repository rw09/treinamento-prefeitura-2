<template>
    <Head title="Protocolos - Detalhes" />
    <section class="container mt-8 mx-auto px-40">
        <form @submit.prevent="add" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100 grid grid-cols-2">
            <h1 class="font-bold mx-auto col-span-2">Protocolo Número #{{ protocolo.id }}</h1>
            <p>{{ protocolo.descricao }}</p>
            <p><strong>Data Cadastro:</strong> {{ new Date(protocolo.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'}) }}</p>
            <p><strong>Departamento:</strong> {{ protocolo.departamento.nome }}</p>
            <p><strong>Solicitante:</strong> {{ protocolo.contribuinte.nome }}</p>
            <div class="col-span-2">
                <label for="observacao">Acompanhamento:</label>
                <textarea v-model="form.observacao" cols="70" rows="8">
                </textarea>
            </div>
            <button class="py-1 px-2 bg-green-400" type="submit">Registrar Acompanhamento</button>
        </form>
        <div>
            <h2>Acompanhamentos:</h2>
            <ul>
                <li class="bg-yellow-500/50 p-4 mb-2" v-for="acompanhamento in acompanhamentos">
                    <div>
                        {{ acompanhamento.observacao }}
                    </div>
                    <div class="text-sm">
                        {{ new Date(acompanhamento.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'}) }}
                    </div>
                    <div>
                      {{ acompanhamento.user_id }} - {{ acompanhamento.user.name }}
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

    const page = usePage();

    const props = defineProps({
        protocolo: Object,
        acompanhamentos: Object
    });

    let form = useForm({
        protocolo_id: props.protocolo.id,
        user_id: page.props.auth.user.id,
        observacao: null,
    });

    let add = () => {
        form.post(route('protocolos-add-acompanhamento'), {
            preserveState: false,
        });
    }

    // let add = () => {
    //     form.post('/protocolos/add-acompanhamento', {
    //         onSuccess: form.reset(),
    //     });
    // }
</script>