<template>
    <Head title="Protocolos - Listagem" />

    <section class="container my-6 mx-auto text-xs">
        <section class="flex justify-between mb-1">
            <div class="flex items-center py-2">
                <Link v-bind:href="route('protocolos-create')" class="py-1.5 px-3 rounded-sm text-sm text-white bg-teal-500 hover:bg-teal-400 z-10">
                    Cadastrar Protocolo
                </Link>
                 <button @click="gerarRelatorioPDF" class="ml-4 py-1.5 px-3 rounded-sm text-sm text-white bg-orange-400 hover:bg-orange-300 z-10">Gerar Relatório</button>
             </div>
            <div class="grid grid-cols-4 gap-x-1 py-2">
                <button @click="pdf" v-bind:class="linhaSelecionada ? 'bg-orange-400 hover:bg-orange-300' : 'bg-gray-300 cursor-default'" class="px-2 py-1 rounded-sm  text-white z-10">PDF</button>
                <button @click="show" v-bind:class="linhaSelecionada ? 'bg-yellow-500 hover:bg-yellow-400' : 'bg-gray-300 cursor-default'" class="px-2 py-1 rounded-sm  text-white z-10">Detalhes</button>
                <button @click="edit" v-bind:class="linhaSelecionada ? 'bg-sky-600/90 hover:bg-blue-400' : 'bg-gray-300 cursor-default'" class="px-2 py-1 rounded-sm  text-white z-10">Editar</button>
                <button @click="remove" v-bind:class="linhaSelecionada ? 'bg-rose-600/80 hover:bg-red-400' : 'bg-gray-300 cursor-default'" class="px-2 py-1 rounded-sm  text-white z-10">Deletar</button>
            </div>
        </section>

        <section class="container py-1 mx-auto text-xs">
            <DataTable id="audit-datatable" :buttons="buttons" :data="protocolos" :columns="columns" :options="options" ref="table" class="display nowrap" width="100%" @select="mostrarBotoes" @deselect="esconderBotoes">
                <thead class="bg-gray-200">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Contribuinte</th>
                        <th>Departamento</th>
                        <th>Data</th>
                        <th>Prazo</th>
                        <th>Situação</th>
                        <th>Acompanhamentos</th>
                        <th>Anexos</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Filtrar por Descrição</th>
                        <th>Filtrar por Contribuinte</th>
                        <th>Filtrar por Departamento</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </DataTable>
        </section>
    </section>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

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
        // { data: 'descricao' },
        { data: null, render: data => data.descricao.length > 50 ? data.descricao.substring(0, 50 -3) + '...' : data.descricao },
        { data: null, render: data => data.contribuinte_id + ' - ' + data.contribuinte.nome }, //usar assim?
        { data: null, render: data => data.departamento_id + ' - ' + data.departamento.nome },
        { data: null, render: data => new Date(data.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) },
        // { data: null, render: data => data.prazo + ' dias' },
        { data: 'prazo' },
        { data: null, render: data => data.situacao == 1 ? 'Concluído' : 'Pendente' },
        { data: 'acompanhamentos_count' },
        { data: 'anexos_count' },
    ];

    const options = {
        responsive: true,
        select: 'single',
        fixedHeader: true,
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
            .columns([1,2,3])
            .every(function () {
                let column = this;
                let title = column.footer().textContent;
 
                // Create input element
                let input = document.createElement('input');
                input.placeholder = title;
                column.footer().replaceChildren(input);
 
                // Event listener for user input
                input.addEventListener('keyup', (e) => {
                    //if (e.key === 'Enter' || e.keyCode === 13) {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    //}
                    
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
            router.get(route('protocolos-show', row.id));
            
        } else {
            avisoSemLinhaSelecionada('Visualizar')
        }
    };

    const edit = () => {
        if(linhaSelecionada.value === true) {
            let row = dt.row({ selected: true }).data();
            router.get(route('protocolos-edit', row.id));
        } else {
            avisoSemLinhaSelecionada('Editar')
        }        
    };

    const remove = () => {
        if(linhaSelecionada.value === true) {
            let row = dt.row({ selected: true }).data();
            Swal.fire({
                title: 'Confirma exclusão desse Protocolo?',
                html: "<b>ID:</b> " + row.id + '<br>' + "<b>Descrição:</b> " + row.descricao + "<br><b>Solicitante:</b> " + row.contribuinte_id + " - " + row.contribuinte.nome 
            + "<br><b>Departamento:</b> " + row.departamento_id + " - " + row.departamento.nome
            + "<br><b>Data:</b> " + new Date(row.created_at).toLocaleString('pt-BR') + "<br><b>Prazo:</b> " + row.prazo + " dias"
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
            text: 'Selecione o Protocolo que deseja ' + msg,
            icon: 'warning',
        })
    }

    const props = defineProps({ protocolos: Object });

    const gerarRelatorioPDF = () => {

        try {
            let protocolo_ids = [];
            let dados = dt.rows({ search:'applied' }).data().toArray();
           
            
            dados.forEach(prot => {
                protocolo_ids.push(prot.id);
            });


            axios.post('/protocolos/relatorio', { protocolo_ids }, 
                { responseType: 'blob' })
                .then(res => {
                    let blob = new Blob([res.data], { type: res.headers['content-type'] });
                    let link = document.createElement('a');

                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Relatório.pdf";
                    link.click()
                }).catch(err => {
                    console.log('Erro na resposta: ' + err)
                });
        } catch (error) {
            console.log('Erro ao gerar PDF: ', error);
        }
    }

    const pdf = () => {

        if(linhaSelecionada.value === true) {
            
            try {
                let protocolo = dt.row({ selected: true }).data().id;
                
                console.log(protocolo)

                axios.post('/protocolos/pdf', { protocolo }, 
                    { responseType: 'blob' })
                    .then(res => {
                        let blob = new Blob([res.data], { type: res.headers['content-type'] });
                        let link = document.createElement('a');

                        link.href = window.URL.createObjectURL(blob);
                        link.download = `Protocolo-${protocolo}.pdf`;
                        link.click()
                    }).catch(err => {
                        console.log('Erro na resposta: ' + err)
                    });
            } catch (error) {
                console.log('Erro ao gerar PDF: ', error);
            }
        } else {
            avisoSemLinhaSelecionada('Gerar o PDF')
        }        

        
    }
</script>

