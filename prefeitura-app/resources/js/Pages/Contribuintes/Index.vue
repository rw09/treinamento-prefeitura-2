<template>
    <Head title="Contribuintes - Listagem" />
    
    <section class="container my-6 mx-auto text-xs">
        <section class="flex justify-between mb-1">
            <div class="flex items-center py-2">
                <!-- <h1 class="font-bold text-3xl pr-6">Usuários</h1> -->
                <Link v-bind:href="route('contribuintes-create')" class="py-1.5 px-3 rounded-sm text-sm text-white bg-teal-500 hover:bg-teal-400">
                    Cadastrar Contribuinte
                </Link>
            </div>
            <div class="grid grid-cols-3 gap-x-1 py-2">
                <!-- <button :disabled="!linhaSelecionada" @click="show" class="bg-yellow-500/90 px-2 py-1 rounded-sm hover:bg-yellow-200 text-white">Ver</button> -->
                <!-- <button :disabled="!linhaSelecionada" @click="edit" class="bg-sky-600/90 px-2 py-1 rounded-sm hover:bg-blue-200 text-white">Editar</button>
                <button v-if="linhaSelecionada" @click="remove" class="bg-rose-600/80 px-2 py-1 rounded-sm hover:bg-red-200 text-white">Deletar</button> -->
                <!-- <button :disabled="!linhaSelecionada" @click="show" class="bg-yellow-500/90 px-2 py-1 rounded-sm hover:bg-yellow-200 text-white">Ver</button>
                <button :disabled="!linhaSelecionada" @click="edit" class="bg-sky-600/90 px-2 py-1 rounded-sm hover:bg-blue-200 text-white">Editar</button>
                <button :disabled="!linhaSelecionada" @click="remove" class="bg-rose-600/80 px-2 py-1 rounded-sm hover:bg-red-200 text-white">Deletar</button> -->
                <button @click="show" v-bind:class="linhaSelecionada ? 'bg-yellow-500 hover:bg-yellow-400' : 'bg-gray-300 cursor-default'" class="px-2 py-1 rounded-sm  text-white">Detalhes</button>
                <button @click="edit" v-bind:class="linhaSelecionada ? 'bg-sky-600/90 hover:bg-blue-400' : 'bg-gray-300 cursor-default'" class="px-2 py-1 rounded-sm  text-white">Editar</button>
                <button @click="remove" v-bind:class="linhaSelecionada ? 'bg-rose-600/80 hover:bg-red-400' : 'bg-gray-300 cursor-default'" class="px-2 py-1 rounded-sm  text-white">Deletar</button>
            </div>
        </section>

        <section class="container py-1 mx-auto text-xs">
            <DataTable id="datatable" :buttons="buttons" :data="contribuintes" :columns="columns" :options="options" ref="table" class="display nowrap" width="100%" @select="mostrarBotoes" @deselect="esconderBotoes">
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
                        <th>Protocolos</th>
                    </tr>
                </thead>
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
        { data: 'nome' },
        // { data: null, render: data => data.nome.length > 50 ? data.nome.substring(0, 50 -3) + '...' : data.nome }, // o search nao pega a parte que foi cortada
        { data: null, render: data => new Date(data.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) },
        { data: null, render: data => data.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') },
        { data: null, render: data => data.sexo == 'M' ? 'Masculino' : 'Feminino' },
        { data: null, render: data => data.rua ? (data.rua + ", " + (data.numero ? data.numero : "s/nº") + (data.complemento ? " - " + data.complemento : "")) : "" },
        { data: 'bairro' },
        { data: 'cidade' },
        { data: 'protocolos_count'}
    ];


    const options = {
        responsive: true,
        select: 'single',
        stateSave: true,
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

    let linhaSelecionada = ref(false);

    let mostrarBotoes = () => {
        linhaSelecionada.value = true;
    }

    let esconderBotoes = () => {
        linhaSelecionada.value = false;
    }

    const show = () => {
        if(linhaSelecionada.value === true) {
            let row = dt.row({ selected: true }).data();
            router.get(route('contribuintes-show', row.id));
            
        } else {
            avisoSemLinhaSelecionada('Visualizar')
        }
    };

    const edit = () => {
        if(linhaSelecionada.value === true) {
            let row = dt.row({ selected: true }).data();
            router.get(route('contribuintes-edit', row.id));

        } else {
            avisoSemLinhaSelecionada('Editar')
        }        
    };

    // const remove = () => {
    //     dt.rows({ selected: true }).every(function () {
    //         let row = this.data();
    //         if(confirm('Deseja realmente deletar esse Contribuinte?\n\n' + "ID: " + row.id + "\nNome: " + row.nome + "\nData de Nascimento: " + new Date(row.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) + "\nCPF: " + row.cpf
    //         + "\nEndereço: " + (row.rua ? (row.rua + ", " + (row.numero ? row.numero : "s/nº") + (row.complemento ? " - " + row.complemento : "")) : "") 
    //         + "\nBairro: " + row.bairro + "\nCidade: " + row.cidade))
    //         {
    //             router.delete(route('contribuintes-destroy', row.id));
    //         };
    //     });
    // }

    const remove = () => {
        if(linhaSelecionada.value === true) {
            let row = dt.row({ selected: true }).data();
            Swal.fire({
                title: 'Confirma exclusão desse Contribuinte?',
                html: "<b>ID:</b> " + row.id + '<br>' + '<b>Nome:</b> ' + row.nome + '<br>' + '<b>CPF:</b> ' + row.cpf,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.delete(route('contribuintes-destroy', row.id));
                        Swal.fire({
                        timer: 2500,
                        title: 'Deletado!',
                        text: 'Contribuinte excluído com sucesso.',
                        icon: 'success',
                    })
                }
                linhaSelecionada.value = false;
            })
        } else {
            avisoSemLinhaSelecionada('Deletar')
        }
    };

    const avisoSemLinhaSelecionada = (msg) => {
        Swal.fire({
            timer: 2500,
            title: 'Nenhum Registro Selecionado!',
            text: 'Selecione o Contribuinte que deseja ' + msg,
            icon: 'warning',
        })
    };


    const props = defineProps({ contribuintes: Object });
</script>