<template>
    <div class="flex justify-center">
        <!-- <Component 
            :is="link.url ? 'Link' : 'span'"
            v-for="link in links"
            v-bind:href="link.url"
            v-html="link === links[0] ? 'Anterior' : (link === links[links.length-1] ? 'Próxima' : link.label)"
            class="px-2.5 py-1 border first:rounded-l first:border-r-0 first:px-3 last:rounded-r last:border-l-0 last:px-3"
            v-bind:class="{'text-gray-400' : !link.url, 'font-bold bg-gray-200' : link.active}"
        />    -->  
    <Component 
            :is="link.url ? 'Link' : 'span'"
            v-for="link in links"
            v-bind:href="link.url"
            v-html="link === links[0] ? 'Anterior' : (link === links[links.length-1] ? 'Próxima' : link.label)"
            class="px-2.5 first:px-3 last:rounded-r last:px-3"
            v-bind:class="{'text-gray-400' : !link.url, 'underline underline-offset-4 text-slate-700' : link.active}"
        />
    </div>
</template>

<script setup>
    const props = defineProps({links: Array});
</script>