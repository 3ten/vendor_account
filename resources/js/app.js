/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router' 
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import App from './views/App.vue'
import Hello from './views/Hello.vue'
import Home from './views/Home.vue'
import Stats from './views/Stats.vue'
import Login from './views/Login.vue'
import Register from './views/Register'
import Dashboard from './views/Dashboard'

Vue.component('random-chart', require('./components/RandomChart.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

axios.defaults.baseURL = 'http://localhost:8000';

const router = new VueRouter({
    mode: 'history',
    routes: [
      {
        path: '/',
        name: 'home',
        component: Home
      },
      {
        path: '/hello',
        name: 'hello',
        component: Hello,
      },
      {
          path: '/stats',
          name: 'stats',
          component: Stats,
      },
      {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
          auth: false
        },
      },
      {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
          auth: false
        },
      },
      {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true
        },
      },
    ],
  });

  Vue.router = router
  Vue.use(require('@websanova/vue-auth'), {
     auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
     http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
     router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
  });
  
  App.router = Vue.router;
  
  new Vue(App).$mount('#app');



