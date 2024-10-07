<template>
    <default-layout>
        <div class="flex flex-col" style="width:600px">
            <div class="flex flex-col">
                <div class="flex">
                    <div class="w-1/2 p-2">Name</div>
                    <div class="w-1/6 p-2">Points</div>
                    <div class="w-1/6 p-2">MP</div>
                    <div class="w-1/6 p-2">W</div>
                    <div class="w-1/6 p-2">L</div>
                    <div class="w-1/6 p-2">D</div>
                    <div class="w-1/6 p-2">Goal balance</div>
                </div>
                <div class="flex" v-for="(team, index) in teams" :key="index">
                    <div class="w-1/2 p-2">{{ team.name }}</div>
                    <div class="w-1/6 p-2">{{ team.points }}</div>
                    <div class="w-1/6 p-2">{{ team.matches_played }}</div>
                    <div class="w-1/6 p-2">{{ team.wins }}</div>
                    <div class="w-1/6 p-2">{{ team.loses }}</div>
                    <div class="w-1/6 p-2">{{ team.draws }}</div>
                    <div class="w-1/6 p-2">{{ team.goal_balance }}</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="p-4 rounded-2xl bg-gray-200 hover:bg-gray-300 text-center cursor-pointer"
                     @click="simulateRound">
                    Simulate round
                </div>
            </div>
            <div class="flex flex-col w-full mt-4">
                <div class="flex justify-between">
                    <div class="w-1/3 p-2">Home</div>
                    <div class="w-1/3 p-2 text-center">Guest</div>
                    <div class="w-1/3 p-2 text-right">Score</div>
                </div>
                <div class="flex justify-between" v-for="(round, index) in rounds" :key="index">
                    <div class="w-1/3 p-2">{{ round.homeTeam }}</div>
                    <div class="w-1/3 p-2 text-center">{{ round.guestTeam }}</div>
                    <div class="w-1/3 p-2 text-right">{{ round.score }}</div>
                </div>
            </div>
            <div class="flex flex-col mt-4" v-if="showOdds">
                <div class="text-lg text-gray-700 font-semibold">
                    Changes of each team to win the league
                </div>
                <div class="" v-for="(odd, index) in odds">
                    {{ index }} - {{ odd }} %
                </div>
            </div>
        </div>
    </default-layout>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import DefaultLayout from "../layouts/defaultLayout.vue";
import axios from "axios";
import Pusher from "pusher-js";

export default defineComponent({
    components: {DefaultLayout},
    created() {
        this.getTeams()
        this.getRounds()
    },
    mounted() {
        const key = process.env.MIX_PUSHER_APP_KEY || ''
        const cluster = process.env.MIX_PUSHER_CLUSTER || ''

        const pusher = new Pusher(key, {
            cluster: cluster
        });
        const channel = pusher.subscribe('my-channel');
        channel.bind('my-event', (data: any) =>{
            this.odds = data.odds
            this.showOdds = true
        });
    },
    data() {
        return {
            teams: [],
            rounds: [],
            odds: null,
            showOdds: false
        }
    },
    methods: {
        async getTeams() {
            try {
                const {data} = await axios.get('api/teams')
                this.teams = data.data.data
            } catch (err: any) {
                console.error(err)
            }
        },
        async simulateRound() {
            try {
                this.odds = null
                this.showOdds = false
                const {status} = await axios.get('api/rounds/simulate')
                if (status === 200) {
                    await this.getTeams()
                    await this.getRounds()
                }
            } catch (err: any) {
                console.error(err)
            }
        },
        async getRounds() {
            try {
                const {data} = await axios.get('api/rounds')
                this.rounds = data.data.data
            } catch (err: any) {
                console.error(err)
            }
        },
    }
})
</script>
