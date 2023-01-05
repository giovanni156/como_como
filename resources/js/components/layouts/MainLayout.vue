<template>
    <the-navbar></the-navbar>
    <div class="relative flex flex-col items-center justify-center">
        <router-view></router-view>
    </div>
</template>

<script setup lang="ts">
import TheNavbar from '@/components/partials/TheNavbar.vue'
</script>
