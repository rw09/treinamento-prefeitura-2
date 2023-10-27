<template>

    <Head title="Protocolos - Listagem" />

    <section class="container mt-6 mx-auto shadow-md">
        <div class="flex justify-between items-center p-2 bg-gray-200">
            <form class="flex w-1/3">
                <input v-model="pesquisa" class="h-7 px-2 text-xs" type="search" name="pesquisa" id="pesquisa" placeholder="Pesquise por descrição ou solicitante">
            </form>
            <Link v-bind:href="route('protocolos-create')" class="py-1.5 px-3 rounded shadow-md text-sm text-white bg-teal-500 hover:bg-teal-400">
                Cadastrar
            </Link>
        </div>
    </section>

    <section class="container mt-4 mb-10 mx-auto shadow-sm text-xs">
        <DataTable :buttons="buttons" :data="protocolos" :columns="columns" :options="options" class="display nowrap" width="100%">
            <thead class="bg-gray-200">
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Solicitante</th>
                    <th>Departamento</th>
                    <th>Data</th>
                    <th>Prazo</th>
                    <th>Situação</th>
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
        { data: 'descricao' },
        { data: null, render: data => data.contribuinte_id + ' - ' + data.contribuinte.nome }, //usar assim?
        { data: null, render: data => data.departamento_id + ' - ' + data.departamento.nome },
        { data: null, render: data => new Date(data.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) },
        // { data: null, render: data => data.prazo + ' dias' },
        { data: 'prazo' },
        { data: null, render: data => data.situacao == 1 ? 'Concluído' : 'Pendente' },
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


    const props = defineProps({
        protocolos: Object,
        filters: Object
    });


    let destroy = (id) => { //depois trocar por um modal!
        if (confirm('Are you sure?')){
            router.delete(route('protocolos-destroy', id));
        }
    };
</script>