<template>

    <div class="w-1/5">
        <img src="https://www.saoleopoldo.rs.gov.br/templates/BASE/imagens/logoPMSL.png" 
            alt="Logo Prefeitura São Leopoldo">
    </div>
    <nav class="mr-4">
        <ul class="flex gap-6 text-sm">
            <li>
                <NavLink
                    v-bind:href="route('home')"
                    v-bind:active="$page.component === 'Home'"
                >
                    Home
                </NavLink>
            </li>
            <li>
                <NavLink
                    v-bind:href="route('contribuintes-index')"
                    v-bind:active="$page.url.startsWith('/contribuintes')"
                >
                    Contribuintes
                </NavLink>
            </li>
            <li>
                <NavLink
                    v-bind:href="route('protocolos-index')"
                    v-bind:active="$page.url.startsWith('/protocolos')"
                >
                    Protocolos
                </NavLink>
            </li>
            <li v-if="perfil === 0 || perfil === 1">
                <NavLink
                    v-bind:href="route('users-index')"
                    v-bind:active="$page.url.startsWith('/users')"
                >
                    Usuários
                </NavLink>
            </li>
            <li v-if="perfil === 0 || perfil === 1">
                <NavLink
                    v-bind:href="route('departamentos-index')"
                    v-bind:active="$page.url.startsWith('/departamentos')"
                >
                    Departamentos
                </NavLink>
            </li>
            <li v-if="perfil === 0">
                <NavLink
                    v-bind:href="route('audits-index')"
                    v-bind:active="$page.url.startsWith('/audits')"
                >
                    Auditoria
                </NavLink>
            </li>
            <li class="pl-8">
                <NavLink v-bind:href="route('logout')" method="post">
                    Sair
                </NavLink>
            </li>
        </ul>
    </nav>
</template>

<script setup>
    import NavLink from './NavLink.vue';
    import { usePage } from '@inertiajs/vue3'
    import { computed } from 'vue';

    const page = usePage();
    const perfil = computed(() => page.props.auth.user.perfil_acesso);
</script>