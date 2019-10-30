<template>
    <div class="container">
        <div class="row">
            <div class="col-xl-8 ">
                <div data-spy="scroll" class="pre-scrollable cards-box">
                    <ul class="list-group cards-box">
                        <div v-bind:key="el" v-for="el in data">
                            <div class="col-xl-12">
                                <li class="list-group-item">{{el.name}} </li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Order",
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
                axios.get('/getOrder').then((response) => {
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