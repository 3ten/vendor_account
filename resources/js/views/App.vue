<template>
    <div>
        <h1>Vue Router Demo App</h1>
<<<<<<< HEAD
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
=======

        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'hello' }">Hello World</router-link> |
            <router-link :to="{ name: 'stats' }">Statistic</router-link> |
            <router-link :to="{ name: 'cards' }">Cards</router-link>
            <router-link :to="{ name: 'order' }">Order</router-link>
        </p>
>>>>>>> f468ac976cfbc2ef58446a7a36b6f053d97112ce

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script> 