<template>
    <default-layout>
        <h1 class="text-red-500">Lorem Ipsum</h1>
    </default-layout>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import DefaultLayout from "../layouts/defaultLayout.vue";

export default defineComponent({
    components: {DefaultLayout},
    layout: 'default'
})
</script>
