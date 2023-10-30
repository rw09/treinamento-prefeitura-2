<template>
    <Head title="Protocolos - Listagem" />

    <section class="container my-6 mx-auto text-xs">
        <section class="flex justify-between mb-1">
            <div class="flex items-center">
                <!-- <h1 class="font-bold text-3xl pr-6">Usuários</h1> -->
                <Link v-bind:href="route('protocolos-create')" class="py-1.5 px-3 rounded-sm text-sm text-white bg-teal-500 hover:bg-teal-400">
                    Cadastrar Protocolo
                </Link>
            </div>
            <div class="grid grid-cols-3 gap-x-1 py-2">
                <button @click="show" class="bg-yellow-500/90 px-2 py-1 rounded-sm hover:bg-yellow-200">Ver</button>
                <button @click="edit" class="bg-sky-600/90 px-2 py-1 rounded-sm hover:bg-blue-200">Editar</button>
                <button @click="remove" class="bg-rose-600/80 px-2 py-1 rounded-sm hover:bg-red-200">Deletar</button>
            </div>
        </section>

        <section class="container py-1 mx-auto text-xs">
            <DataTable id="datatable" :data="protocolos" :columns="columns" :options="options" ref="table" class="display nowrap" width="100%">
                <thead class="bg-gray-200">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Solicitante</th>
                        <th>Departamento</th>
                        <th>Data</th>
                        <th>Prazo</th>
                        <th>Situação</th>
                        <th>Acompanhamentos</th>
                    </tr>
                </thead>
            </DataTable>
        </section>
    </section>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';

import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-responsive';
import 'datatables.net-select';

DataTable.use(DataTablesCore);

    let page = usePage();

    let dt;
    const table = ref();

    onMounted(function () {
        dt = table.value.dt;

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

const columns = [
        { data: 'id' },
        { data: 'descricao' },
        { data: null, render: data => data.contribuinte_id + ' - ' + data.contribuinte.nome }, //usar assim?
        { data: null, render: data => data.departamento_id + ' - ' + data.departamento.nome },
        { data: null, render: data => new Date(data.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) },
        // { data: null, render: data => data.prazo + ' dias' },
        { data: 'prazo' },
        { data: null, render: data => data.situacao == 1 ? 'Concluído' : 'Pendente' },
        { data: 'acompanhamentos_count' },
    ];


    const options = {
        responsive: true,
        select: 'single',
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


    const show = () => {
        dt.rows({ selected: true }).every(function () {
            let row = this.data();
            router.get(route('protocolos-show', row.id));
        });        
    }

    const edit = () => {
        dt.rows({ selected: true }).every(function () {
            let row = this.data();
            router.get(route('protocolos-edit', row.id));
        });        
    }

    // const remove1 = () => {
    //     dt.rows({ selected: true }).every(function () {
    //         let row = this.data();
    //         if(confirm('Deseja realmente deletar esse Protocolo?\n\n' + "ID: " + row.id + "\nDescrição: " + row.descricao + "\nSolicitante: " + row.contribuinte_id + " - " + row.contribuinte.nome 
    //         + "\nDepartamento: " + row.departamento_id + " - " + row.departamento.nome
    //         + "\nData: " + new Date(row.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) + "\nPrazo: " + row.prazo + " dias"
    //         + "\nSituação: " + (row.situacao == 1 ? 'Concluído' : 'Pendente' )))
    //         {
    //             router.delete(route('protocolos-destroy', row.id));
    //         };
    //     });
    // }

    const remove = () => {
        dt.rows({ selected: true }).every(function () {
            let row = this.data();
            Swal.fire({
                title: 'Confirma exclusão desse Protocolo?',
                html: "<b>ID:</b> " + row.id + '<br>' + "<b>Descrição:</b> " + row.descricao + "<br><b>Solicitante:</b> " + row.contribuinte_id + " - " + row.contribuinte.nome 
            + "<br><b>Departamento:</b> " + row.departamento_id + " - " + row.departamento.nome
            + "<br><b>Data:</b> " + new Date(row.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) + "<br><b>Prazo:</b> " + row.prazo + " dias"
            + "<br><b>Situação:</b> " + (row.situacao == 1 ? 'Concluído' : 'Pendente' ),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.delete(route('protocolos-destroy', row.id));
                        Swal.fire({
                        timer: 2500,
                        title: 'Deletado!',
                        text: 'Protocolo excluído com sucesso.',
                        icon: 'success',
                    })
                }
            })
        });
    }

    const props = defineProps({ protocolos: Object });
</script>