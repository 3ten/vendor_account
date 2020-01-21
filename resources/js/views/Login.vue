<template>
    <div>
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div v-if="!loading">
            <div class="alert alert-danger" v-if="error">
                <p>There was an error, unable to sign in with those credentials.</p>
            </div>
            <form autocomplete="off" @submit.prevent="login" method="">
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
        mounted() {
            if (this.$route.query.token) {
                this.token = this.$route.query.token;
                axios.post('/auth/parse', {token: this.token}).then(response => {
                    this.email = response.data.email;
                    this.password = response.data.password;
                }).catch(response => {
                    console.log("Ошибка!");
                });
                setTimeout( () => {
                    this.login();
                    console.log("auth");
                }, 1000)
            }
        },
    
    methods: {
        login(){
            var redirect = this.$auth.redirect();
            var app = this;
            this.loading = true;
            this.$auth.login({
                data: {
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