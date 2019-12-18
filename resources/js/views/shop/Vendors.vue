<template>
    <div>
         <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
         <div v-if="!loading" class="col-12">
            <div data-spy="scroll" class="pre-scrollable cards-box">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Статус</th>
                            <th scope="col">Код</th>
                            <th scope="col">ИНН</th>
                            <th scope="col">КПП</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Город</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Комментарий</th>
                            <th scope="col">Оприходован</th>
                            <th scope="col">Форма собственности</th>
                            <th scope="col">Полное наименование</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :key="el.id" v-for="el in data" v-on:click="onClick(el.id)">
                            <th scope="row"> {{el.id}}</th>
                            <td> {{el.inn}}</td>
                            <td> {{el.kpp}}</td>
                            <td> {{el.name}}</td>
                            <td> {{el.tel}}</td>
                            <td> {{el.city}}</td>
                            <td> {{el.address}}</td>
                            <td> {{el.comment}}</td>
                            <td> {{el.isAccept}}</td>
                            <td> {{el.ownkind}}</td>
                            <td> {{el.fullName}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            data: [],
        }
    },
    mounted() {
       this.loading = false; 
    },
    created() {
        this.update();
    },
    methods: {
        update() {
            this.loading = true;
            axios.get('/getVendors').then((response) => {
                this.loading = false;
                this.data = response.data;
                console.dir(response.data);
            });
        }
    }
}
</script>