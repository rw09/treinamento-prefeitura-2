<template>
    <section class="m-8">
        <h1 class="underline mb-2 font-bold">Dados do Usuário:</h1>
        <p>
            <strong>Nome:</strong> {{ nome_usuario }}
        </p>
        <p v-if="perfil_acesso === 0">
            <strong>Perfil de Acesso:</strong> {{ perfil_acesso }} - Administrador da TI
        </p>
        <p v-else-if="perfil_acesso === 1">
            <strong>Perfil de Acesso:</strong> {{ perfil_acesso }} - Administrador do Sistema
        </p>
        <p v-else>
            <strong>Perfil de Acesso:</strong> {{ perfil_acesso }} - Operador
        </p>
        
        <Link :href="route('user-change-password')" class="bg-blue-400 hover:bg-blue-300 block w-fit mt-2 px-2 py-1 text-white rounded-sm">Alterar a Senha</Link>
        
        <h2 v-if="perfil_acesso === 0 || perfil_acesso === 1" class="mt-4 font-bold">Possui acesso à todos os Departamentos:</h2>
        <h2 v-else class="mt-4 font-bold">Departamentos em que possui acesso:</h2>
        <ul class="list-disc ml-8" v-if="departamentos.length">
            <li v-for="departamento in departamentos">{{ departamento.nome }}</li>
        </ul>
        <h3 v-else>Nenhum departamento</h3>
       
    </section>
    
    

</template>

<script setup>
import { computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

    onMounted(function () {
        if(page.props.flash.message) {
            Swal.fire({
                title: 'Sucesso!',
                html: page.props.flash.message,
                timer: 2500,
                icon: 'success',
            })  
            page.props.flash.message = null
        } 
    });

    const props = defineProps({
        departamentos: Object,
    });

    const page = usePage();
    const nome_usuario = computed(() => page.props.auth.user.nome);
    const perfil_acesso = computed(() => page.props.auth.user.perfil_acesso);

</script>