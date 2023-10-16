<template>
    
    <header class="flex justify-between items-center p-2 shadow-md bg-gray-200">
        <NavMenu />
    </header>

    <main>
        <slot />
    </main>

</template>

<script setup>
    import NavMenu from './NavMenu.vue';
</script>