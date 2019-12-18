<template>
    <div>
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div v-if="!loading">
            <div class="alert alert-danger" v-if="error">
                <p>There was an error, unable to sign in with those credentials.</p>
            </div>
            <form autocomplete="off" @submit.prevent="login" method="post">
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
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
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
            this.$auth.login({
                params: {
                    email: app.email,
                    password: app.password,
                }, 
                success: function () {
                    const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 0 ? 'shop.dashboard' : 'dashboard';
                    this.$router.push({name: redirectTo});
                    this.loading = false;
                },
                error: function () {
                    app.has_error = true;
                    this.loading = false;
                },
                rememberMe: true,
                fetchUser: true,
            });       
        },
    }
  } 
</script>