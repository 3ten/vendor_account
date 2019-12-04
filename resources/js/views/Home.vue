<template>
    <div v-if="!$auth.check()" class="row align-items-center" style="height: 100vh;">
        <div class="col-4 offset-4 text-center">
            <p>
                <router-link :to="{ name: 'login' }">Войти</router-link>
            </p>
            <p>
                <router-link :to="{ name: 'register' }">Зарегистрироваться</router-link>
            </p> 
        </div>
    </div>
</template>