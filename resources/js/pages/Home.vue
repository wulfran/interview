<template>
    <default-layout>
        <div class="p-4 rounded-2xl bg-gray-200 hover:bg-gray-300">Test</div>
    </default-layout>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import DefaultLayout from "../layouts/defaultLayout.vue";
import axios from "axios";

export default defineComponent({
    components: {DefaultLayout},
    mounted() {
        this.getTeams()
    },
    data() {
        return {
            'teams': []
        }
    },
    methods: {
    }
})
</script>
