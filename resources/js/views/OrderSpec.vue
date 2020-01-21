<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Dropdown
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Accept</button>
                        </form>
                    </div>
                </nav> -->
                <div class="searching">
                    <label for="search">Фильтр:</label>
                    <input type="text" v-model="search" placeholder="Введите данные">
                </div>
            </div>
        </div>
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
                        <tr v-for="item in filterData" :key="item.articul">
                            <th scope="row"> {{ item.articul }}</th>
                            <td> {{ item.name }}</td>
                            <td> {{ item.quantity +' '+item.meas }}</td>
                            <td> {{ item.rub }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
                search: '',
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update() {
                console.dir(this.id);
                axios.post('/getOrderList', {id: this.id}).then((response) => {
                    this.data = response.data;
                    console.dir(this.data);
                });
            },
        },
        computed: {
            filterData() {
                return this.data.filter(order => {
                    return (order.articul.toLowerCase().includes(this.search.toLowerCase()) || order.name.toLowerCase().includes(this.search.toLowerCase())) 
                });
            },
        },

    }
</script>

<style scoped>
    .cards-box {
        padding: 10px;
        min-height: 80vh;
        overflow-x: hidden;
    }
</style>