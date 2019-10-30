<template>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 ">
                <div data-spy="scroll" class="pre-scrollable cards-box">
                    <div v-if="loading">sdfsdfsdfsef</div>
                    <div v-for="el in data">
                        <div class="row my-2">
                            <div class="col-xl-12">
                                <div class="card">
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
    </div>
</template>


<script>
    export default {
        name: "Cards",
        data() {
            return {
                data: []
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            async update () {
                await axios.get('/api/getCards').then((response) => {
                    this.data = response.data;
                    console.dir(response.data);
                });
            }
        }
    }


</script>

<style scoped>
    .cards-box {
        padding: 10px;
        min-height: 80vh;
        overflow-x: hidden;
    }
</style>

