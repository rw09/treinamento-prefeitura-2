<template>
    <section class="container mt-8 mx-auto px-40">
        <form @submit.prevent="submit" class="mx-20 pt-4 px-10 pb-12 rounded shadow-md bg-gray-100">
            <h1 class="text-center mt-2 mb-8 underline underline-offset-4 decoration-slate-400 text-slate-800">Cadastrar Protocolo</h1>
            <div class="flex flex-col justify-center gap-x-4">
                <div class="grid grid-cols-2 gap-4 w-full">
                    <div>
                        <label for="contribuinte">Contribuinte:</label>
                        <select name="contribuinte" id="contribuinte" v-model="form.contribuinte_id" class="px-3 mt-1 py-1 w-full border rounded text-sm" required @change="form.validate('contribuinte_id')">
                            <option v-for="contribuinte in contribuintes" v-bind:value="contribuinte.id">{{ contribuinte.cpf }} - {{ contribuinte.nome }}</option>
                        </select>
                        <div v-if="form.errors.contribuinte_id" v-text="form.errors.contribuinte_id" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div>
                        <label for="departamento">Departamento:</label>
                        <select name="departamento" id="departamento" v-model="form.departamento_id" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('departamento_id')">
                            <option v-for="departamento in departamentos" v-bind:value="departamento.id">{{ departamento.nome }}</option>
                        </select>
                        <div v-if="form.errors.departamento_id" v-text="form.errors.departamento_id" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div>
                        <label for="descricao" class="block text-xs">Descricao:</label>
                        <input v-model="form.descricao" type="text" name="descricao" id="descricao" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('descricao')">
                        <div v-if="form.errors.descricao" v-text="form.errors.descricao" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div>
                        <label for="prazo" class="block text-xs">Prazo:</label>
                        <input v-model="form.prazo" type="number" name="prazo" id="prazo" class="px-3 mt-1 py-1 w-full border rounded" required @change="form.validate('prazo')">
                        <div v-if="form.errors.prazo" v-text="form.errors.prazo" class="text-red-400 text-xs mt-1"></div>
                    </div>
                    <div>
                        <label for="anexos">Anexar Documentos:</label>
                        <p class="text-xs pb-1">Máximo 5 arquivos (.jpg, .jpeg, .png ou .pdf) com até 3MB cada</p>
                        <input type="file" multiple accept=".jpg, .jpeg, .png, .pdf" @change="anexar">
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <Link v-bind:href="(route('protocolos-index'))" class="mt-8 px-4 py-2 rounded font-medium bg-rose-600/80 text-white hover:bg-red-400">Cancelar</Link>
                <button type="submit" class="mt-8 px-4 py-2 rounded font-medium bg-teal-500 text-white hover:bg-teal-400" :disabled="form.processing">Cadastrar</button>
            </div>
        </form>
    </section>  
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import Swal from 'sweetalert2';

    const props = defineProps({
        departamentos: Object,
        contribuintes: Object
    });

    const form = useForm('post', route('protocolos-store'), {
        contribuinte_id: null,
        departamento_id: null,
        descricao: '',
        prazo: '',
        situacao: 0,
        anexos: '',
    });

    const anexar = (e) => {
        if(e.target.files) 
        {
            const tamanhoMaximoArquivo = 3 * 1024 * 1024;
            const extensoesSuportadas = ["application/pdf", "image/jpg", "image/jpeg", "image/png"];

            if(e.target.files.length > 5)
            {
                avisoErroAnexo('Erro!<br> Quantidade de anexos', 'A quantidade de arquivos permitidos é <b>5</b>');
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

    const submit = () => form.submit();
</script>