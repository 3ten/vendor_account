<template>
    <div>
        <div class="row mb-2">
            <h2 class="col-2 ">Товары</h2>
            <v-md-date-range-picker show-year-select
                                    @change="handleChange"></v-md-date-range-picker>
        </div>


        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
             aria-hidden="true" id="myModal">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавить товар</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Дата</th>
                                <th class="text-right" scope="col">остаток</th>
                                <th class="text-right" scope="col">количество проданных</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in cardSales">
                                <td> {{item.date}}</td>
                                <td class="text-right"> {{item.ost}}</td>
                                <td class="text-right"> {{item.sales}}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div data-spy="scroll" class="pre-scrollable cards-box col-12 m-0 p-0">
            <sorted-table class="table table-hover table-fixed" :values="data" ascIcon="<span> ▲</span>"
                          descIcon="<span> ▼</span>">
                <thead class="thead-light">
                <tr>
                    <th scope="col">
                        <sort-link name="articul">Артикул</sort-link>
                    </th>
                    <th scope="col">
                        <sort-link name="name">Наименование</sort-link>
                    </th>
                    <th scope="col" class="text-right">
                        <sort-link name="ost">Остаток</sort-link>
                    </th>
                    <th scope="col" class="text-right">
                        <sort-link name="markup">Наценка</sort-link>
                    </th>
                    <th scope="col" class="text-right">
                        <sort-link name="markup_per">Наценка в %</sort-link>
                    </th>
                    <th scope="col" class="text-right">
                        <sort-link name="retail_price">Розничная цена</sort-link>
                    </th>
                    <th scope="col" class="text-right">
                        <sort-link name="retail_sum">Сумма продаж</sort-link>
                    </th>
                    <th scope="col" class="text-right">
                        <sort-link name="client_price">Моя цена</sort-link>

                    </th>
                    <th scope="col" class="text-right">
                        <sort-link name="sales">Продажи</sort-link>
                    </th>
                </tr>
                </thead>
                <template #body="sort">
                    <tbody>
                    <tr v-for="item in sort.values" :key="item.articul" v-on:click="getCardSales(item.articul)">
                        <th scope="row"> {{ item.articul }}</th>
                        <td> {{ item.name }}</td>
                        <td class="text-right"> {{ item.ost }}</td>
                        <td class="text-right"> {{ item.markup}}</td>
                        <td class="text-right"> {{ item.markup_per}}</td>
                        <td class="text-right"> {{ item.retail_price}}</td>
                        <td class="text-right"> {{ item.retail_sum}}</td>
                        <td class="text-right"> {{ item.client_price}}</td>
                        <td class="text-right"> {{ item.sales}}</td>
                    </tr>
                    </tbody>
                </template>

            </sorted-table>
        </div>
        <h2 class="mb-3 mt-3">Продажи</h2>
        <div data-spy="scroll" class="pre-scrollable cards-box col-6 m-0 p-0">
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Дата</th>
                    <th class="text-right" scope="col">сумма продаж поставщик</th>
                    <th class="text-right" scope="col">количество проданных</th>
                    <th class="text-right" scope="col">сумма продаж магазин</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="item in dataSales" :key="item.date">
                    <th scope="row">{{item.date}}</th>
                    <td class="text-right">{{ Math.round(item.sales_client_sum)}}</td>
                    <td class="text-right">{{ Math.round(item.sales_quant)}}</td>
                    <td class="text-right">{{ Math.round(item.sales_retail_sum)}}</td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>

</template>
<script>
    import {SortedTable, SortLink} from "vue-sorted-table";

    export default {
        name: "OrderSpec",
        components: {
            SortedTable,
            SortLink
        },
        data() {
            return {
                values: [],
                data: [],
                dataSales: [],
                sortParam: '',
                cardSales: '',
                begin_date: '2018-12-10',
                end_date: '2019-10-10',
                fdb_l: this.$auth.user().fdb_login,
                fdb_path: this.$auth.user().fdb_path,
                fdb_pass: this.$auth.user().fdb_password,
                inn: this.$auth.user().inn,
                kpp: this.$auth.user().kpp,
                client_id: 'null',
            }
        },
        created() {
            this.update();
        },
        methods: {
            handleChange(values, startDate, endDate) {
                console.log(startDate);
                this.begin_date = startDate[0];
                this.end_date = startDate[1];
                this.values = values;
                this.update();
            },
            update() {
                console.log('start');
                this.getCard();
                this.getSales();

            }, getCardSales(articul) {
                axios.post('/getCardSales', {
                    articul: articul,
                    begin_date: this.begin_date,
                    end_date: this.end_date,
                }).then((response) => {
                    this.cardSales = response.data;
                    console.dir(this.cardSales);
                });

                $('#myModal').modal('show');
            }, getSales() {
                axios.post('/getSalesAnalysis', {
                    fdb_login: this.fdb_l,
                    fdb_path: this.fdb_path,
                    fdb_password: this.fdb_pass,
                    client_inn: this.inn,
                    client_kpp: this.kpp,
                    client_id: this.client_id,
                    begin_date: this.begin_date,
                    end_date: this.end_date,
                }).then((response) => {
                    this.dataSales = response.data;
                    console.dir(this.dataSales);
                });
            },
            getCard() {
                axios.post('/getCardAnalysis', {
                    fdb_login: this.fdb_l,
                    fdb_path: this.fdb_path,
                    fdb_password: this.fdb_pass,
                    client_inn: this.inn,
                    client_kpp: this.kpp,
                    client_id: this.client_id,
                    begin_date: this.begin_date,
                    end_date: this.end_date,
                }).then((response) => {
                    this.data = response.data;
                    console.dir(this.data);
                });
            }
        }, computed: {}
    }
</script>

