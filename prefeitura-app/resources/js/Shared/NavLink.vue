<template>

    <Link class="hover:underline underline-offset-4 decoration-slate-400" 
        v-bind:class="{'underline underline-offset-4 decoration-slate-400' : active}"
    >
        <slot />
    </Link>
    
</template>

<script setup>
    defineProps({
        active: Boolean
    });
</script>