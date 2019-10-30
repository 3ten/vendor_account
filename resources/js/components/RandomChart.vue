<template>
    <div class="small">
        <line-chart :chart-data="data"></line-chart>
        <button @click="fillData()">Randomize</button>
    </div>
</template>

<script>
    import LineChart from '../LineChart.js'

    export default {
        components: {
            LineChart
        },
        data() {
            return {
                data: []
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update() {
                axios.get('/api/getData').then((response) => {
                    this.data = response.data;
                    console.log(response.data+ 'console log');
                });
            }
        }
    }
</script>

<style>
    .small {
        max-width: 600px;
        margin: 150px auto;
    }
</style>