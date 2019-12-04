<template>
    <div>
        <!-- <ul>
            <li v-if="$auth.check()" class="pull-right">
                <router-link :to="{ name: 'order' }">Order</router-link>
            </li>            
            <li v-if="$auth.check()" class="pull-right">
                <router-link :to="{ name: 'cards'}">Cards</router-link>
            </li>
            <li v-if="!$auth.user().role === 2" class="pull-right">
                <router-link :to="{ name: 'register' }">Register</router-link>
            </li>
            <li v-if="$auth.check()" class="pull-right">
                <a href="#" @click.prevent="$auth.logout()">Logout</a>
            </li>
        </ul> -->
        <nav v-if="$auth.check()" class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <a class="navbar-brand" href="#">Vendor Account</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'dashboard' }">Главная</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'order' }">Заказы</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'cards' }">Товары</router-link>
                    </li>
                </ul>
               <div class="dropdown my-2 my-lg-0 pull-right">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $auth.user().name }} 
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Профиль</a>
                        <div class="dropdown-divider">

                        </div>
                        <a class="dropdown-item" href="#" @click.prevent="$auth.logout()">Выход</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script> 