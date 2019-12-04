<template>
    <div class="row mainBlock">
        <div class="col-xl-4">
            <div data-spy="scroll" class="pre-scrollable cards-box">
                <b-spinner v-if="loadingCards"></b-spinner>
                <div v-if="!loadingCards">
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
        </div>
        <div class="col-xl-4">
            <b-spinner v-if="loadingOst"></b-spinner>
            <line-chart v-if="!loadingOst" :chart-data="datacollection"></line-chart>
        </div>
        <div class="col-xl-4">
            <b-spinner v-if="loadingPrix"></b-spinner>
            <line-chart v-if="!loadingPrix" :chart-data="datacollprix"></line-chart>
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
                datacollection: {},
                datacollprix: {},
                loadingCards: false,
                loadingOst: false,
                loadingPrix: false,
            }
        },
        mounted() {
            //this.update()
        },
        created() {
            this.update();
        },
        methods: {
            update() {
                this.loadingCards = true;
                axios.get('/getCards').then((response) => {
                    this.loadingCards = false;
                    this.data = response.data;
                    console.dir(response.data);
                });
            },
            onClick(id) {
                this.loadingOst = true;
                axios.post('/getOst', {id: id}).then((response) => {
                    this.loadingOst = false;
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

                this.loadingPrix = true;
                axios.post('/getPrix', {id: id}).then((response) => {
                    this.loadingPrix = false;
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

