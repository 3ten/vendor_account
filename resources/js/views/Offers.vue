<template>
    <div class="container">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">Создать
            товар
        </button>

        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавить товар</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Наименование</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-default">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Единица измерения</label>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01">
                                <option selected>Выбрать</option>
                                <option value="1">КГ</option>
                                <option value="2">ШТ</option>
                            </select>
                        </div>


                        <div class="input-group">
                            <input type="text" class="form-control"
                                   aria-label="Dollar amount (with dot and two decimal places)">
                            <div class="input-group-append">
                                <span class="input-group-text">₽</span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!--<div class="cardBox myCards col-xl-6">-->
            <!--Мои товары-->
            <!--<div class="card">-->
            <!--<div class="card-body">-->
            <!--Наименование: Тест1-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="card">-->
            <!--<div class="card-body">-->
            <!--Наименование: Тест2-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->


            <div data-spy="scroll" class="pre-scrollable cards-box col-xl-6">
                Мои товары
                <b-spinner v-if="loadingCards"></b-spinner>
                <div v-if="!loadingCards">
                    <div :key="el.articul" v-for="el in data">
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

            <div class="cardBox waitCards col-xl-6">
                В ожидании
                <div class="card">
                    <div class="card-body">
                        Наименование: молоко
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        Наименование: сыр
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Offers",
        data() {
            return {
                data: [],
                loadingCards: false,
            }
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
        }
    }

</script>

<style scoped>
    .cards-box {
        padding: 10px;
        min-height: 85vh;
        overflow-x: hidden;
    }

</style>



