<template>
    <default-layout>
        <div class="p-4 rounded-2xl bg-gray-200 hover:bg-gray-300" @click="lorem">Test</div>
    </default-layout>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import DefaultLayout from "../layouts/defaultLayout.vue";

export default defineComponent({
    components: {DefaultLayout},
    mounted() {},
    methods: {}
})
</script>
