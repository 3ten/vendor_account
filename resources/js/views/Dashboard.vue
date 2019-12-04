<template>
    <div>
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div v-if="!loading">
            <h1>Добро пожаловать!</h1>
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