<template>
    <div class="row">
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div v-if="!loading" class="col-12">
            <div data-spy="scroll" class="pre-scrollable cards-box">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Внешнее основание</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr :key="el.dochead" v-for="el in data" v-on:click="onClick(el.dochead)">
                        <th scope="row"> {{el.dochead}}</th>
                        <td>-{{el.ext_docindex}}</td>
                        <td> {{el.date}}</td>
                        <td> {{el.rub}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Order",
        data() {
            return {
                data: [],
                loading: false,
            }
        },
        mounted() {
            //this.update();
        },
        created() {
            this.update();
        },
        methods: {
            update() {
                this.loading = true;
                axios.get('/getOrder').then((response) => {
                    this.loading = false;
                    this.data = response.data;
                    console.dir(response.data);
                });
            },
            onClick(id_dochead) {

                this.$router.push({name: 'orderList', params: {id: id_dochead}});

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