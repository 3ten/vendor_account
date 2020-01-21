<template>
    <div>
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div v-if="!loading">
            <h1>Добро пожаловать!</h1>
            <div class="row mb-5">
                <div class="col-xl-3">
                    <div class="card bg-info widget">
                        <div class="card-body">
                            Видео с полки
                        </div>
                    </div>
                </div>
                <div class="col-xl-3" v-on:click="onClick('Stats')">
                    <div class="card widget">
                        <div class="card-body">
                            анализ продаж
                        </div>
                    </div>
                </div>
                <div class="col-xl-3" v-on:click="onClick('Reconc')">
                    <div class="card widget">
                        <div class="card-body">
                            сверка
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card widget">
                        <div class="card-body">
                            отчет
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xl-3" v-on:click="onClick('order')">
                    <div class="card widget">
                        <div class="card-body">
                            заказ
                        </div>
                    </div>

                </div>
                <div class="col-xl-3" v-on:click="onClick('offer')">
                    <div class="card widget">
                        <div class="card-body">
                            предложения новинок
                        </div>
                    </div>

                </div>
                <div class="col-xl-3">
                    <div class="card widget">
                        <div class="card-body">
                            управления
                        </div>
                    </div>

                </div>
                <div class="col-xl-3">
                    <div class="card widget">
                        <div class="card-body">
                            о432423
                        </div>
                    </div>
                </div>
            </div>

            <h2 v-if="$auth.user().role === 0">Аккаунт: магазин</h2>
            <h2 v-if="$auth.user().role === 1">Аккаунт: поставщик</h2>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
            }
        },
        mounted() {
            this.loading = false;
        },
        created() {
            this.loading = true;
        }, methods: {
            onClick(pages) {
                this.$router.push(pages);
            }

        }
    }
</script>
<style>
    .widget{
        height: 250px;
        transition: linear 0.12s 0.01s;
        background: #ffe6ce5e !important;
        box-shadow: 2px 2px 10px 0px rgba(0, 0, 0, 0.5);
    }

    .widget:hover {
        background: #fff !important;
        box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.5);

    }
</style>