<template>
    <div class="row mainBlock">
        <div class="col-xl-4">
            <div data-spy="scroll" class="pre-scrollable cards-box">
                <div :key="el.articul" v-for="el in data">
                    <div class="row my-2">
                        <div class="col-xl-12">
                            <div class="card" v-on:click="onClick(el.articul)">
                                <div class="card-header">
                                    Артикул: {{el.articul}}
                                </div>
                                <div class="card-body">
                                    <div class="row"> name: {{el.name}}</div>
                                    <div class="row"> ost: {{el.ost}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <line-chart :chart-data="datacollection"></line-chart>
        </div>
        <div class="col-xl-4">
            <line-chart :chart-data="datacollprix"></line-chart>
        </div>
    </div>

</template>


<script>
    import LineChart from '../LineChart.js';

    export default {
        components: {
            LineChart
        },
        name: "Cards",
        data() {
            return {
                data: [],
                ostData: [],
                prixData: [],
                datacollection: null,
                datacollprix: null,
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update() {

                axios.get('/getCards').then((response) => {
                    this.data = response.data;
                    console.dir(response.data);
                });
            },
            onClick(id) {
                axios.post('/getOst', {id: id}).then((response) => {
                    this.ostData = response.data;
                    console.dir(this.ostData.ost);
                    console.dir(this.ostData.date);
                    this.datacollection = {
                        labels: this.ostData.date,
                        datasets: [
                            {
                                label: 'Data One',
                                backgroundColor: '#f87979',
                                data: this.ostData.ost
                            }
                        ]
                    }
                });

                axios.post('/getPrix', {id: id}).then((response) => {
                    this.prixData = response.data;
                    console.dir(this.prixData.quant);
                    console.dir(this.prixData.date);
                    this.datacollprix = {
                        labels: this.prixData.date,
                        datasets: [
                            {
                                label: 'Data One',
                                backgroundColor: '#9cf82c',
                                data: this.prixData.quant
                            }
                        ]
                    }
                });

            }
        }
    }


</script>

<style scoped>

    .cards-box {
        padding: 10px;
        min-height: 70vh;
        overflow-x: hidden;
    }
</style>

