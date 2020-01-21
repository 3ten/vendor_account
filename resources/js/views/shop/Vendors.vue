<template>
    <div>
         <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
         <div v-if="!loading" class="col-12">
            <!-- Modal -->
            <div class="modal fade" id="vendorSettings" tabindex="-1" role="dialog" aria-labelledby="vendorSettingsLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="vendorSettingsLabel">{{ vendor.name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-sm">
                                <tbody>
                                    <tr>
                                        <th scope="row">Код</th>
                                        <td> {{vendor.code}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Статус</th>
                                        <td> {{vendor.status}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ИНН</th>
                                        <td> {{vendor.inn}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">КПП</th>
                                        <td> {{vendor.kpp}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Телефон</th>
                                        <td> {{vendor.tel}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Город</th>
                                        <td> {{vendor.city}}</td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Адрес</th>
                                        <td> {{vendor.address}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Комментарий</th>
                                        <td> {{vendor.comment}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Оприходован</th>
                                        <td> {{vendor.isAccept}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Форма собственности</th>
                                        <td> {{vendor.ownkind}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Полное наименование</th>
                                        <td> {{vendor.fullName}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <form class="form-inline justify-content-around" v-if="vendor.status === 0" action="" @submit.prevent="sendMessage" method="post">
                                <div class="form-group">
                                    <input type="text" v-model="mail.vendor_id" name="vendor_id" id="vendor_id" hidden>
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="mail.shop_id" name="shop_id" id="shop_id" hidden>
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="mail.inn" name="inn" id="inn" hidden>
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="mail.kpp" name="kpp" id="kpp" hidden>
                                </div>
                                <div class="form-group col-8">
                                    <input type="email" class="form-control" v-model="mail.email" name="email" id="email" placeholder="Электронная почта" required>
                                </div>
                                <div class="form-grou col-4">
                                    <input class="btn btn-primary" type="submit" value="Пригласить">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div data-spy="scroll" class="pre-scrollable cards-box ">
                <table class="table table-striped table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Наименование</th>
                            <th scope="col">Активен</th>
                            <th scope="col">Доступ к ЛК</th>
                            <th scope="col">Может мне писать</th>
                            <th scope="col">Может видеть цены</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :key="el.id" v-for="el in data" >
                            <th scope="row" data-toggle="modal" data-target="#vendorSettings" v-on:click="setCurrentVendor(el)"> {{el.name}}</th>
                            <td><i v-if="el.isActive" class="far fa-check-square"></i></td>
                            <td v-if="el.status === 1"><input type="checkbox" v-model="el.hasAccess" name="hasAccess" id="hasAccess"></td>
                            <td v-if="el.status === 1"><input type="checkbox" v-model="el.canMessage" name="canMessage" id="canMessage"></td>
                            <td v-if="el.status === 1"><input type="checkbox" v-model="el.canSeePrices" name="canSeePrices" id="canSeePrices"></td>
                            <td v-if="el.status === 0"><input type="checkbox" v-model="el.hasAccess" name="hasAccess" id="hasAccess" disabled></td>
                            <td v-if="el.status === 0"><input type="checkbox" v-model="el.canMessage" name="canMessage" id="canMessage" disabled></td>
                            <td v-if="el.status === 0"><input type="checkbox" v-model="el.canSeePrices" name="canSeePrices" id="canSeePrices" disabled></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <button class="btn btn-primary" v-on:click="saveOptions">Сохранить</button>
                <div v-if="saveLoading">
                    <div class="spinner-border text-primary"></div>
                </div>
                <div v-if="afterSaveSuccess">
                    <span>Сохранено</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            saveLoading: false,
            afterSaveSuccess: false,
            data: [],
            updatedOptions: [],
            newVendorId: null,
            vendorOptions: {
                vendor_id: null,
                shop_id: null,
                hasAccess: false,
                canMessage: false,
                canSeePrices: false,
            },
            vendor: {
                id: null,
                password: null,
                password_confirmation: null,
                code: null,
                status: null,
                inn: null,
                kpp: null,
                name: null,
                tel: null,
                city: null,
                address: null,
                comment: null,
                isAccept: false,
                ownkind: null,
                fullName: null,
                hasAccess: false,
                canMessage: false,
                canSeePrices: false,
            },
            mail: {
                shop_id: null,
                vendor_id: null,
                vendor_inn: null,
                vendor_kpp: null,
                vendor_email: null,
            }
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
            axios.post('/getVendors', {shop_id: this.$auth.user().id}).then((response) => {
                this.loading = false;
                this.data = response.data;
                console.dir(response.data);
            });
        },
        saveOptions() {
            this.data.forEach(vendorElem => {
                if (vendorElem.id) {
                    this.vendorOptions = {};
                    this.vendorOptions.vendor_id = vendorElem.id;
                    this.vendorOptions.shop_id = this.$auth.user().id;
                    this.vendorOptions.hasAccess = vendorElem.hasAccess;
                    this.vendorOptions.canMessage = vendorElem.canMessage;
                    this.vendorOptions.canSeePrices = vendorElem.canSeePrices;
                    this.updatedOptions.push(this.vendorOptions);
                }
            });
            console.dir(this.updatedOptions);
            this.afterSaveSuccess = false;
            this.saveLoading = true;
            axios.post('/saveVendor', {data: this.updatedOptions}).then((response) => {
                this.updatedOptions = [];
                this.saveLoading = false;
                this.afterSaveSuccess = true;
            });
        },
        setCurrentVendor(el) {
            this.vendor.id = el.id;
            this.vendor.code = el.code;
            this.vendor.status = el.status;
            this.vendor.inn = el.inn;
            this.vendor.kpp = el.kpp;
            this.vendor.name = el.name;
            this.vendor.tel = el.tel;
            this.vendor.city = el.city;
            this.vendor.address = el.address;
            this.vendor.comment = el.comment;
            this.vendor.isAccept = el.isAccept;
            this.vendor.ownkind = el.ownkind;
            this.vendor.fullName = el.fullName;
            this.vendor.hasAccess = el.hasAccess;
            this.vendor.canMessage = el.canMessage;
            this.vendor.canSeePrices = el.canSeePrices;
            this.mail.vendor_id = el.id;
            this.mail.shop_id = this.$auth.user().id;
            this.mail.vendor_inn = el.inn;
            this.mail.vendor_kpp = el.kpp;
            this.mail.email = "";
        },
        async sendMessage() {
            this.vendor.password = Math.random().toString(36).slice(-8);
            this.vendor.password_confirmation = this.vendor.password;
            let mailOptions = {
                // vendor_id: this.mail.vendor_id,
                // shop_id: this.mail.shop_id,
                // vendor_inn: this.mail.vendor_inn,
                // vendor_kpp: this.mail.vendor_kpp,
                email: this.mail.email,
                password: this.vendor.password,
            };
            await axios.post('/auth/register', {name: this.vendor.name, password: this.vendor.password, password_confirmation: this.vendor.password_confirmation, email: this.mail.email, inn: this.vendor.inn, kpp: this.vendor.kpp, phone: this.vendor.tel}).then(response => {
                this.newVendorId = response.data.registered_id;
                console.log(this.newVendorId);
                console.log("Добавлен");    
            }).catch(response => {
                console.log("Не добавлен");
            });
            
            await axios.post('/createRelation', {vendor_id: this.newVendorId, shop_id: this.$auth.user().id}).then(response => {
                console.log("Отношение создано");
            }).catch(response => {
                console.log("Ошибка создания отношения");
            });

            await axios.post('/sendMessage', {data: mailOptions, email: mailOptions.email}).then(response => {
                console.log("Отправлено");
            }).catch(response => {
                console.log("Ошибка");
            });
        }
    }
}
</script>