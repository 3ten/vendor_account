<template>
    <div class="container">
        <div class="alert alert-danger" v-if="error && !success">
            <p>There was an error, unable to complete registration.</p>
        </div>

        <div class="alert alert-success" v-if="success">
            <p>Registration completed. You can now <router-link :to="{name:'login'}">sign in.</router-link></p>
        </div>

        <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
            
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="name" required>
                <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                <label for="inn">ИНН</label>
                <input type="text" id="inn" class="form-control" v-model="inn" required>
                <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                <label for="name">КПП</label>
                <input type="text" id="kpp" class="form-control" v-model="kpp" required>
                <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
            </div>

            <div class="form-check form-check-inline" v-bind:class="{ 'has-error': error && errors.name }">
                <input type="radio" class="form-check-input" v-model="role" value="1" name="role" id="role1" required>
                <label for="role">Поставщик</label>
            </div>

            <div class="form-check form-check-inline" v-bind:class="{ 'has-error': error && errors.name }">
                <input type="radio" class="form-check-input" v-model="role" value="0" name="role" id="role0" required>
                <label for="role">Магазин</label>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                <label for="name">Телефон</label>
                <input type="text" id="phone" class="form-control" v-model="phone" required>
                <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                <span class="help-block" v-if="error && errors.email">{{ errors.email }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
                <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
</template>
<script> 
    export default {
        data(){
            return {
                name: '',
                inn: '',
                kpp: '',
                role: '',
                phone: '',
                email: '',
                password: '',
                password_confirmation: '',
                has_error: false,
                error: '',
                errors: {},
                success: false,
            };
        },

        methods: {
            register(){
                var app = this
                this.$auth.register({
                    data: {
                        name: app.name,
                        inn: app.inn,
                        kpp: app.kpp,
                        role: app.isShop,
                        phone: app.phone,
                        email: app.email,
                        password: app.password,
                        password_confirmation: app.password_confirmation,
                    }, 
                    success: function () {
                        app.success = true;
                        this.$router.push({name: 'login', params: {successRegistrationRedirect: true}});
                    },
                    error: function (res) {
                        console.log(res.response.data.errors);
                        app.has_error = true;
                        app.error = res.response.data.error;
                        app.errors = res.response.data.errors || {};
                    },
                });                
            }
        }
    }
</script>