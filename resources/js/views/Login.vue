<template>
    <div>
        <div class="alert alert-danger" v-if="error">
            <p>There was an error, unable to sign in with those credentials.</p>
        </div>
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div>
            <button v-on:click="isLogin = true; isCode = false;" class="btn btn-primary">Вход по логину</button>
            <button v-on:click="isLogin = false; isCode = true;" class="btn btn-primary">Вход по коду</button>
        </div>
        <form v-if="isLogin" autocomplete="off" @submit.prevent="login" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        <form v-if="isCode" autocomplete="off" @submit.prevent="login" method="post">
            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" id="code" class="form-control" v-model="code" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>  
        </form>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                isLogin: false,
                isCode: true,
                email: null,
                password: null,
                code: null,
                error: false,
                loading: false
            }
        },
    methods: {
        login(){
            var redirect = this.$auth.redirect();
            var app = this;
            this.loading = true;
            if (this.isCode) {
                this.$auth.login({
                    params: {
                        //email: app.email,
                        //password: app.password,
                        code: app.code,
                    }, 
                    success: function () {
                        const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'admin.dashboard' : 'dashboard';
                        this.$router.push({name: redirectTo});
                        this.loading = false;
                    },
                    error: function () {
                        app.has_error = true;
                    },
                    rememberMe: true,
                    fetchUser: true,
                });  
            } 
            if (this.isLogin) {
                this.$auth.login({
                    params: {
                        email: app.email,
                        password: app.password,
                        //code: app.code,
                    }, 
                    success: function () {
                        const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'admin.dashboard' : 'dashboard';
                        this.$router.push({name: redirectTo});
                        this.loading = false;
                    },
                    error: function () {
                        app.has_error = true;
                    },
                    rememberMe: true,
                    fetchUser: true,
                });  
            }         
        },
    }
  } 
</script>