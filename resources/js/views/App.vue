<template>
    <div>
        <h1>Vue Router Demo App</h1>
        <ul>
            <li>
                <router-link :to="{ name: 'home' }">Home</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'hello' }">Hello World</router-link>
            </li>
            <li>
                <router-link :to="{ name: 'stats' }">Statistic</router-link>
            </li>
            <li v-if="!$auth.check()" class="pull-right">
                <router-link :to="{ name: 'login' }">Login</router-link>
            </li>
            <li v-if="!$auth.check()" class="pull-right">
                <router-link :to="{ name: 'register' }">Register</router-link>
            </li>
            <li v-if="$auth.check()" class="pull-right">
                <a href="#" @click.prevent="$auth.logout()">Logout</a>
            </li>
        </ul>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script> 