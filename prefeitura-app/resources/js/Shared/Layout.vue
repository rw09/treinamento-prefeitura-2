<template>
    
    <header class="fixed top-0 w-screen z-50 flex justify-between items-center p-2 shadow-md bg-gray-200">
        <NavMenu />
    </header>

    <main class="mt-20">
        <slot />
    </main>

</template>

<script setup>
    import NavMenu from './NavMenu.vue';
</script>