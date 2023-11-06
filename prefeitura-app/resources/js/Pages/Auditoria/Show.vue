<template>
    <Head title="Auditoria - Detalhes" />
    <!-- <section class="container mt-8 mx-auto px-40"> -->
        <section class="sm:mx-10 lg:mx-80 space-y-4 shadow-md py-8 mb-6 rounded-md border-2">
            <section class="px-8 py-4">
                <h1 class="font-semibold text-lg mx-auto w-fit mb-10">Auditoria # {{ audit.id }}</h1>
                <h2 class="text-md font-semibold mt-4">Data:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ new Date(audit.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'}) }}</p>
                <h2 class="text-md font-semibold mt-4">Usuário:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ audit.user.name }}</p>
                <h2 class="text-md font-semibold mt-4">Evento:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ audit.event }}</p>
                <h2 class="text-md font-semibold mt-4">Tabela:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ audit.auditable_type }}</p>
                <h2 class="text-md font-semibold mt-4">ID Auditado:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ audit.auditable_id }}</p>
                <h2 class="text-md font-semibold mt-4">Informações Antigas:</h2>
                <p class="p-3 bg-gray-200 rounded break-words">{{ audit.old_values }}</p>
                <h2 class="text-md font-semibold mt-4">Informações Novas:</h2>
                <p class="p-3 bg-gray-200 rounded break-words">{{ audit.new_values }}</p>
                <h2 class="text-md font-semibold mt-4">URL:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ audit.url }}</p>
                <h2 class="text-md font-semibold mt-4">IP:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ audit.ip_address }}</p>
        </section>

          
        
        
        </section>
        
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

    const opcao = ref('contribuinte');

    const page = usePage();

    let form = useForm({});

    const props = defineProps({ audit: Object });
</script>