/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import App from './views/App'
import auth from './auth'
import router from './router'
import BootstrapVue from 'bootstrap-vue'

import FontAwesome from '@fortawesome/fontawesome-free/js/all.js'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.componnpent(key.split('/').pop().split('.')[0], files(key).default))

// Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
Vue.use(VueAuth, auth)  

Vue.use(BootstrapVue)

Vue.component('random-chart', require('./components/RandomChart.vue').default);
Vue.component('app', App);

import SortedTablePlugin from "vue-sorted-table";
Vue.use(SortedTablePlugin);

import VMdDateRangePicker from "v-md-date-range-picker";
Vue.use(VMdDateRangePicker);


import { BSpinner } from 'bootstrap-vue'
Vue.component('b-spinner', BSpinner)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});



