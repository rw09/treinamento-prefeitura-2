<template>
    <Head title="Contribuintes - Listagem" />

    <section class="container my-6 mx-auto text-xs">
        <section class="flex justify-between mb-1">
            <div class="flex items-center">
                <!-- <h1 class="font-bold text-3xl pr-6">Usuários</h1> -->
                <Link v-bind:href="route('contribuintes-create')" class="py-1.5 px-3 rounded-sm text-sm text-white bg-teal-500 hover:bg-teal-400">
                    Cadastrar Contribuinte
                </Link>
            </div>
            <div class="grid grid-cols-3 gap-x-1 py-2">
                <button @click="show" class="bg-yellow-500/90 px-2 py-1 rounded-sm hover:bg-yellow-200">Ver</button>
                <button @click="edit" class="bg-sky-600/90 px-2 py-1 rounded-sm hover:bg-blue-200">Editar</button>
                <button @click="remove" class="bg-rose-600/80 px-2 py-1 rounded-sm hover:bg-red-200">Deletar</button>
            </div>
        </section>

        <section class="container py-1 mx-auto text-xs">
            <DataTable id="datatable" :buttons="buttons" :data="contribuintes" :columns="columns" :options="options" ref="table" class="display nowrap" width="100%">
                <thead class="bg-gray-200">
                    <tr>
                        <th >ID</th>
                        <th>Nome</th>
                        <th>Data Nascimento</th>
                        <th>CPF</th>
                        <th>Sexo</th>
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                    </tr>
                </thead>
            </DataTable>
        </section>
    </section>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-responsive';
import 'datatables.net-select';

DataTable.use(DataTablesCore);

    let dt;
    const table = ref();

    onMounted(function () {
        dt = table.value.dt;
    });

    const columns = [
        { data: 'id' },
        { data: 'nome' },
        { data: null, render: data => new Date(data.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) },
        { data: 'cpf' },
        { data: null, render: data => data.sexo == 'M' ? 'Masculino' : 'Feminino' },
        { data: null, render: data => data.rua ? (data.rua + ", " + (data.numero ? data.numero : "s/nº") + (data.complemento ? " - " + data.complemento : "")) : "" },
        { data: 'bairro' },
        { data: 'cidade' },
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
            router.get(route('contribuintes-show', row.id));
        });        
    }

    const edit = () => {
        dt.rows({ selected: true }).every(function () {
            let row = this.data();
            router.get(route('contribuintes-edit', row.id));
        });        
    }

    const remove = () => {
        dt.rows({ selected: true }).every(function () {
            let row = this.data();
            if(confirm('Deseja realmente deletar esse Contribuinte?\n\n' + "ID: " + row.id + "\nNome: " + row.nome + "\nData de Nascimento: " + new Date(row.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) + "\nCPF: " + row.cpf
            + "\nEndereço: " + (row.rua ? (row.rua + ", " + (row.numero ? row.numero : "s/nº") + (row.complemento ? " - " + row.complemento : "")) : "") 
            + "\nBairro: " + row.bairro + "\nCidade: " + row.cidade))
            {
                router.delete(route('contribuintes-destroy', row.id));
            };
        });
    }


    const props = defineProps({ contribuintes: Object });
</script>