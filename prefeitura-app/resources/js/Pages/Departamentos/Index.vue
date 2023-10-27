<template>
    <Head title="Departamentos - Listagem" />

    <section class="container mt-6 mx-auto shadow-md">
        <div class="flex justify-between items-center p-2 bg-gray-200">
            <form class="flex w-1/3">
                <input v-model="pesquisa" class="h-7 px-2 text-xs" type="search" name="pesquisa" id="pesquisa" placeholder="Pesquise por nome">
            </form>
            <Link v-bind:href="route('departamentos-create')" class="py-1.5 px-3 rounded shadow-md text-sm text-white bg-teal-500 hover:bg-teal-400">
                Cadastrar
            </Link>
        </div>
    </section>

    <section class="container mt-4 mb-10 mx-auto shadow-sm text-xs">
        <DataTable :buttons="buttons" :data="departamentos" :columns="columns" :options="options" class="display nowrap" width="100%">
            <thead class="bg-gray-200">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data Cadastro</th>
                    <th>Quantidade de Operadores</th>
                    <th>Quantidade de Protocolos</th>
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
        { data: 'nome' },
        { data: null, render: data => new Date(data.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'})},
        { data: 'users_count' },
        { data: 'protocolos_count' },
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


    const props = defineProps({ departamentos: Object });

    let destroy = (id) => { //depois trocar por um modal!
        if (confirm('Are you sure?')){
            router.delete(route('departamentos-destroy', id));
        }
    }
</script>
