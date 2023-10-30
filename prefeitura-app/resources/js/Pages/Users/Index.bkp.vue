<template>
    <Head title="Usuários - Listagem" />

    <section class="container mt-6 mx-auto shadow-md">
        <div class="flex justify-between items-center p-2 bg-gray-200">
            <form class="flex w-1/3">
                <input v-model="pesquisa" class="h-7 px-2 text-xs" type="search" name="pesquisa" id="pesquisa" placeholder="Pesquise por nome">
            </form>
            <Link v-bind:href="route('users-create')" class="py-1.5 px-3 rounded shadow-md text-sm text-white bg-teal-500 hover:bg-teal-400">
                Cadastrar
            </Link>
        </div>
    </section>

    <section class="container mt-4 mb-10 mx-auto shadow-sm text-xs">
        <DataTable :buttons="buttons" :data="users" :columns="columns" :options="options" class="display nowrap" width="100%">
            <thead class="bg-gray-200">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>CPF</th>
                    <th>Data Cadastro</th>
                    <th>Perfil de Acesso</th>
                    <th>Nº Departamentos</th>
                </tr>
            </thead>
         </DataTable>
    </section>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-responsive';
import 'datatables.net-select';


DataTable.use(DataTablesCore);

const columns = [
        { data: 'id' },
        { data: 'name' },
        { data: 'email' },
        { data: 'cpf' },
        { data: null, render: data => new Date(data.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'})},
        { data: null, render: data => data.perfil === 0 ? data.perfil + ' - ' + "Administrador da TI" : (data.perfil === 1 ? data.perfil + ' - ' + "Administrador do Sistema" : data.perfil + ' - ' + "Operador") },
        { data: null, render: data => data.perfil === 2 ? data.departamentos_count : 'Acesso à todos' }
    ];

    const options = {
        responsive: true,
        select: true,
        language: {
            search: 'Pesquisar:',
            emptyTable: "Sem dados disponíveis",
            zeroRecords: 'Nenhum registro encontrado',
            info: 'Mostrando de _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: "Mostrando de 0 a 0 de um total de 0 registros",
            paginate: {first: 'Primeira', last: 'Última', previous: 'Anterior', next: 'Próxima'},
            lengthMenu: "Registros por página: _MENU_  &nbsp",
            infoFiltered: "(filtrados de um total de _MAX_ registros)",
            select: { rows: { }}
        }
    };


    const props = defineProps({ users: Object });

    
    let destroy = (id) => { //depois trocar por um modal!
        if (confirm('Are you sure?')){
            router.delete(route('users-destroy', id));
        }
    };
</script>