<template>
    <div>
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div v-if="!loading">
            <h1>Добро пожаловать!</h1>
            <h2 v-if="$auth.user().role === 0">Аккаунт: магазин</h2>
            <h2 v-if="$auth.user().role === 1">Аккаунт: поставщик</h2>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
        }
    },
    mounted() {
       this.loading = false; 
    },
    created() {
        this.loading = true;
    },
}
</script>