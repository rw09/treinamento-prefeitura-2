<template>
    <Head title="Protocolos - Detalhes" />
    <!-- <section class="container mt-8 mx-auto px-40"> -->
        <section class="sm:mx-10 lg:mx-80 space-y-4 shadow-md pb-8 mb-6 rounded-md border-2">
            <nav class="flex bg-slate-200">
                <label for="opcao-protocolo" class="py-2.5 px-4 cursor-pointer hover:bg-white hover:rounded-tl" v-bind:class="{'bg-white rounded-tl font-semibold' : opcao === 'protocolo'}">
                    <input type="radio" value="protocolo" id="opcao-protocolo" name="opcao" v-model="opcao" class="hidden">
                        Protocolo
                    </label>
                <label for="opcao-contribuinte" class="py-2.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-white font-semibold' : opcao === 'contribuinte'}">
                    <input type="radio" value="contribuinte" id="opcao-contribuinte" name="opcao" v-model="opcao" class="hidden">Contribuinte
                </label>
                <label for="opcao-acompanhamentos" class="py-2.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-white font-semibold' : opcao === 'acompanhamentos'}">
                    <input type="radio" value="acompanhamentos" id="opcao-acompanhamentos" name="opcao" v-model="opcao" class="hidden">Acompanhamentos
                </label>
                <label for="opcao-anexos" class="py-2.5 px-4 cursor-pointer hover:bg-white" v-bind:class="{'bg-white font-semibold' : opcao === 'anexos'}">
                    <input type="radio" value="anexos" id="opcao-anexos" name="opcao" v-model="opcao" class="hidden">Anexos
                </label>
            </nav>

            <section class="px-8 py-4" v-if="opcao === 'protocolo'">
                <h1 class="font-semibold text-lg mx-auto w-fit">Protocolo # {{protocolo.id}}</h1>
                <h2 class="text-md font-semibold mt-4">Descrição:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.descricao }}</p>
                <h2 class="text-md font-semibold mt-4">Data:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ new Date(protocolo.created_at).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) }}</p>
                <h2 class="text-md font-semibold mt-4">Prazo:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.prazo }} dias</p>
                <h2 class="text-md font-semibold mt-4">Departamento:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.departamento.nome}}</p>
            </section>

            <section class="px-8 py-4" v-if="opcao === 'contribuinte'">
                <h1 class="font-semibold text-lg mx-auto w-fit">Contribuinte # {{protocolo.contribuinte.id}}</h1>
                <h2 class="text-md font-semibold mt-4">Nome:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.nome }}</p>
                <h2 class="text-md font-semibold mt-4">Data de Nascimento:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ new Date(protocolo.contribuinte.data_nascimento).toLocaleDateString('pt-BR', { timeZone: 'UTC'}) }}</p>
                <h2 class="text-md font-semibold mt-4">CPF:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4') }}</p>
                <h2 class="text-md font-semibold mt-4">Sexo:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.sexo === "M" ? "Masculino" : "Feminino" }}</p>
                <h2 class="text-md font-semibold mt-4">Rua:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.rua ? protocolo.contribuinte.rua : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Número:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.numero ? protocolo.contribuinte.numero : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Complemento:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.complemento ? protocolo.contribuinte.complemento : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Bairro:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.bairro ? protocolo.contribuinte.bairro : '---' }}</p>
                <h2 class="text-md font-semibold mt-4">Cidade:</h2>
                <p class="p-3 bg-gray-200 rounded">{{ protocolo.contribuinte.cidade ? protocolo.contribuinte.cidade : '---' }}</p>
            </section>
        

            <section class="px-8 py-4" v-if="opcao === 'acompanhamentos'">
                <details id="detailsAcompanhamento" class="mb-8">
                    <summary class="text-white bg-teal-500 hover:bg-teal-400 px-4 py-2 w-fit cursor-pointer">Novo Acompanhamento</summary>
                    <form @submit.prevent="add" class="pb-12 mt-4 p-4 rounded shadow-md bg-gray-100 flex flex-col">
                        <h1 class="self-center font-semibold mb-4">Registrar Novo Acompanhamento</h1>
                        <label for="observacao" class="text-sm">Observação:</label>
                        <textarea v-model="form.observacao" cols="70" rows="5" class="p-4">
                        </textarea>
                        <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400" :disabled="form.processing">Registrar Acompanhamento</button>
                    </form>
                </details>

                <div class="bg-yellow-200 p-4 rounded-md flex flex-col mb-2" v-for="acompanhamento, index in acompanhamentos">
                <div class="flex justify-between">
                    <div>
                    <h1 class="font-semibold text-lg">Acompanhamento # {{ acompanhamentos.length - index }}</h1>
                    <p class="text-xs">{{ new Date(acompanhamento.created_at).toLocaleString('pt-BR', { timeZone: 'UTC'}) }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-slate-700">
                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                            <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-slate-700">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                        </svg>

                    </div>
                </div>
                <p class="mt-5">{{ acompanhamento.observacao }}</p>
                <div class="flex justify-end mt-8">
                    <p>{{ acompanhamento.user_id }} - {{ acompanhamento.user.name }}</p>
                </div>
                </div>
            </section>

            <section class="px-8 py-4" v-if="opcao === 'anexos'">
                <details id="detailsAnexo" class="mb-8" v-if="protocolo.anexos.length < 5">
                    <summary class="text-white bg-teal-500 hover:bg-teal-400 px-4 py-2 w-fit cursor-pointer">Anexar Arquivo</summary>
                    <form @submit.prevent="addAnexo" class="pb-12 mt-4 p-4 rounded shadow-md bg-gray-100 flex flex-col">
                        <label for="anexos">Anexar Documentos:</label>
                        <p class="text-xs pb-1">Máximo {{ qtdeArquivosPossivel }} arquivo{{qtdeArquivosPossivel != 1 ? 's' :'' }} (.jpg, .jpeg, .png ou .pdf) com até 3MB cada</p>
                        <input id="inputAnexos" type="file" multiple accept=".jpg, .jpeg, .png, .pdf" @change="anexar">
                        <button type="submit" v-bind:class="anexosSelecionados ? 'text-white bg-teal-500 hover:bg-teal-400' : 'bg-gray-300 text-gray-400'" class="mt-8 px-4 py-2 rounded font-medium" :disabled="anexosSelecionados == false">Fazer Upload</button>
                    </form>
                </details>

                <div v-for="anexo in protocolo.anexos">
                    <h1>{{ anexo.id }}</h1>
                    <h1>{{ anexo.name }}</h1>
                    <h1>{{ anexo.caminho }}</h1>
                    <!-- <img src="{{ url('storage/Protocolo-4/'.$anexo.name) }}"> -->
                    <a :href="'/protocolos/download/' + anexo.id">Baixar</a>
                    <button @click="removeAnexo(anexo)" type="submit" class="ml-2 px-2 bg-red-400" v-bind="anexo.id"> Remover </button> 
                    <hr>
                </div>
             </section>
        
        </section>
        <h1>{{ anexosSelecionados }} </h1>
        <h1>{{ qtdeArquivosPossivel }}</h1>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import Swal from 'sweetalert2';

    const opcao = ref('protocolo');

    const page = usePage();

    const props = defineProps({
        protocolo: Object,
        acompanhamentos: Object,
        url: String
    });

    const anexosSelecionados = ref(false);

    //const qtdeArquivosPossivel = ref(5 - props.protocolo.anexos.length);
    const qtdeArquivosPossivel = computed(() => {
        return 5 - props.protocolo.anexos.length;
    })


    let form = useForm({
        protocolo_id: props.protocolo.id,
        user_id: page.props.auth.user.id,
        observacao: null,
        anexos: '',
    });

    let add = () => {
        form.post(route('protocolos-add-acompanhamento'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {[
                Swal.fire({
                    title: 'Sucesso!',
                    html: page.props.flash.message,
                    timer: 2500,
                    icon: 'success',
                }),  
                form.reset('observacao'),
                fecharDetail()
            ]}
        });
    }

    const anexar = (e) => {
        if(e.target.files) 
        {
            const tamanhoMaximoArquivo = 3 * 1024 * 1024;
            const extensoesSuportadas = ["application/pdf", "image/jpg", "image/jpeg", "image/png"];
            // const qtdeArquivosPossivel = 5 - props.protocolo.anexos.length

            //if(e.target.files.length > (5 - props.protocolo.anexos.length))
            if(e.target.files.length > qtdeArquivosPossivel.value)
            {
                console.log(qtdeArquivosPossivel)
                avisoErroAnexo('Erro!<br> Quantidade de anexos', `A quantidade de arquivos permitidos é <b>${qtdeArquivosPossivel.value}</b>`);
                e.target.value = null
                return;
            }
            for(let i = 0; i < e.target.files.length ; i++)
            {
                if (e.target.files[i].size > tamanhoMaximoArquivo) 
                {
                    //depois melhorar
                    //avisoErroAnexo('1 ou mais arquivos com tamanho inválido<br><br>Tamanho máximo de cada arquivo permitido é <b>3MB</b>');
                    avisoErroAnexo('Erro!<br> Tamanho Inválido', 'Arquivo <b>' + e.target.files[i].name + '</b> <br><br>Tamanho máximo de cada arquivo permitido é <b>3MB</b>');
                    e.target.value = null
                    return;
                }
                if(!extensoesSuportadas.includes(e.target.files[i].type))
                {
                    avisoErroAnexo('Erro!<br> Formato Inválido', 'Arquivo <b>' + e.target.files[i].name + '</b> <br><br>Formatos Permitidos: <b><br>.jpg  .jpeg .png  .pdf</b>');
                    e.target.value = null
                    return;
                }
            }
            form.anexos = e.target.files;
            anexosSelecionados.value = true;
            console.log("FORM: " + form.anexos[0].name)
            console.log("TARGET: " + e.target.files[0].name)
            
        }
    }

    const avisoErroAnexo = (errorTitle, msg) => {
        Swal.fire({
            timer: 3500,
            title: errorTitle,
            html: msg,
            icon: 'warning',
        })
    };

    let addAnexo = () => {
        form.post(route('protocolos-add-anexo'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {[
                Swal.fire({
                    title: 'Sucesso!',
                    html: page.props.flash.message,
                    timer: 2500,
                    icon: 'success',
                }),  
                limparSelecao(),
            ]}
        });
    }

    let limparSelecao = () => {
        anexosSelecionados.value = false;
        console.log('LIMPOU')
        if(props.protocolo.anexos.length < 5) {
            let inputAnexos = document.getElementById('inputAnexos')
            inputAnexos.value = ""

            let detailsAnexo = document.getElementById('detailsAnexo')
            detailsAnexo.removeAttribute('open')
        }

        
    }

    let fecharDetail = () => {
        let detailsAcompanhamento = document.getElementById('detailsAcompanhamento')
        detailsAcompanhamento.removeAttribute('open')
    }

    let formAnexos = useForm({
        protocolo_id: props.protocolo.id,

    });

    let removeAnexo = (anexo) => {
        Swal.fire({
            title: 'Confirma exclusão desse Anexo?',
            html: "<b>ID:</b> " + anexo.id + '<br>' + '<b>Nome:</b> ' + anexo.name + '<br>' + "<b>Caminho:</b> " + anexo.caminho,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar!',
            })
            .then((result) => {
                if (result.isConfirmed) {
                    formAnexos.delete(route('protocolos-remove-anexo', anexo.id));
                    Swal.fire({
                        timer: 2500,
                        title: 'Deletado!',
                        text: 'Anexo removido com sucesso.',
                        icon: 'success',
                    }),
                    limparSelecao()
                }
        })
    };
</script>