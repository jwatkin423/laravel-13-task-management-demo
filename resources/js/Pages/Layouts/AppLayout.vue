<script setup>
import Navbar from './Navbar.vue'

</script>

<template>
    <div class="min-h-screen">
        <Navbar />

        <main class="max-w-7xl mx-auto py-8 px-4">
            <slot />
        </main>
    </div>
</template>
