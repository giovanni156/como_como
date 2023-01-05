<template>
    <nav id="the-navbar">
        <div class="left-side">
            <div class="log"></div>

        </div>
        <div
            v-if="isAuthenticated"
            class="right-side"
        >
            <div>
                <p>{{ user.name }},
                <span class="underline cursor-pointer">
                    Logout
                </span>
                </p>
            </div>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const isAuthenticated = computed(() => {
    return true
})

const user = computed(() => {
    return {
        name: 'Juan'
    }
})
</script>
