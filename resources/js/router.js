import VueRouter from 'vue-router'

//pages
import Hello from './views/Hello.vue'
import Home from './views/Home.vue'
import Stats from './views/Stats.vue'
import Login from './views/Login.vue'
import Register from './views/Register'
import Dashboard from './views/Dashboard'
import Cards from './views/Cards'
import Order from './views/Order'

const router = new VueRouter({
    history: true,
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
      {
        path: '/cards',
        name: 'cards',
        component: Cards,
        meta: {
          auth: true
        },
      },
      {
        path: '/order',
        name: 'order',
        component: Order,
        meta: {
          auth: true
        }
      }
    ],
  });

  export default router;