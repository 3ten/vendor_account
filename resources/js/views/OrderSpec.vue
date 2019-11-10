<template>
    <div class="row">
        <div class="col-12">
            <div data-spy="scroll" class="pre-scrollable cards-box">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Артикул</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in data" :key="item.articul">
                        <th scope="row"> {{ item.articul }}</th>
                        <td> {{ item.name }}</td>
                        <td> {{item.quantity +' '+item.meas}}</td>
                        <td> {{item.rub}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        name: "OrderSpec",
        data() {
            return {
                data: [],
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update() {
                // console.log(this.$router);
                console.dir(this.id);
                axios.post('/getOrderList',  {id: this.id}).then((response) => {
                    this.data = response.data;
                    console.dir(this.data);
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