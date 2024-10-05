<template>
    <div id="content-wrapper">
        <main class="min-h-screen pt-8 flex items-center justify-center">
            <slot></slot>
        </main>
    </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: 'defaultLayout'
})
</script>
