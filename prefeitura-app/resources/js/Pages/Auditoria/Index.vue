<template>
    <Head title="Auditoria - Listagem" />
    
    <section class="container my-6 mx-auto text-xs">
        <section class="flex justify-end mb-1">

            <div class="grid grid-cols-1 py-2 items-center z-10">
                <button @click="show" v-bind:class="linhaSelecionada ? 'bg-yellow-500 hover:bg-yellow-400' : 'bg-gray-300'" class="px-2 py-2 rounded-sm  text-white">Visualizar Detalhes</button>
            </div>
        </section>

        <section class="container py-1 mx-auto text-xs">
            <DataTable id="audit-datatable" :buttons="buttons" :data="audits" :columns="columns" :options="options" ref="table" class="display nowrap" width="100%" @select="mostrarBotoes" @deselect="esconderBotoes">
                <thead class="bg-gray-200">
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Evento</th>
                        <th>Data</th>
                        <th>Tabela</th>
                        <th>ID Auditado</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Filtrar por Usuário</th>
                        <th>Filtrar por Evento</th>
                        <th>Filtrar por Data</th>
                        <th>Filtrar por Tabela</th>
                        <th></th>
                    </tr>
                </tfoot>
            </DataTable>
        </section>
    </section>
</template>

<script setup>
import { router, usePage  } from '@inertiajs/vue3';
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
        { data: null, render: data => data.user_id + ' - ' + data.user.name },
        { data: 'event' },
        { data: null, render: data => new Date(data.created_at).toLocaleString('pt-BR') },
        { data: 'auditable_type' },
        { data: 'auditable_id' },
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
        },
        initComplete: function () {
        this.api()
            .columns([1,2,3,4])
            .every(function () {
                let column = this;
                let title = column.footer().textContent;
 
                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);
 
                // Event listener for user input
                input.addEventListener('keyup', () => {
                    if (column.search() !== this.value) {
                        column.search(input.value).draw();
                    }
                });
            });
        }
    };

    let linhaSelecionada = ref(false);

    let mostrarBotoes = () => {
        if(dt.row({ selected: true }).data() !== undefined) {
            linhaSelecionada.value = true;
        }
    }

    let esconderBotoes = () => {
        linhaSelecionada.value = false;
    }

    const show = () => {
        if(linhaSelecionada.value === true) {
            let row = dt.row({ selected: true }).data();
            router.get(route('audits-show', row.id));
            
        } else {
            avisoSemLinhaSelecionada('Visualizar')
        }
    };

    const avisoSemLinhaSelecionada = (msg) => {
        Swal.fire({
            timer: 2500,
            title: 'Nenhum Registro Selecionado!',
            text: 'Selecione a Auditoria que deseja ' + msg,
            icon: 'warning',
        })
    };


    const props = defineProps({ audits: Object });
</script>