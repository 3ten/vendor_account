import VueRouter from 'vue-router'

//pages
import Hello from './views/Hello.vue'
import Home from './views/Home.vue'
import Stats from './views/Stats.vue'
import Login from './views/Login.vue'
import Register from './views/Register'

//shop
import ShopDashboard from './views/shop/Dashboard'
import Vendors from './views/shop/Vendors'

//vendor
import Dashboard from './views/Dashboard'
import Cards from './views/Cards'
import Order from './views/Order'
import OrderList from './views/OrderSpec'

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
                auth: {roles: [1, 2, 3], redirect: {name: 'login'}, forbiddenRedirect: '/403'}
            },
        },
        {
            path: '/shop',
            name: 'shop.dashboard',
            component: ShopDashboard,
            meta: {
                auth: {roles: 0, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
            },
        },
        {
            path: '/vendors',
            name: 'shop.vendors',
            component: Vendors,
            meta: {
                auth: {roles: 0, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
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
        },
        {
            path: '/orderList',
            name: 'orderList',
            component: OrderList,
            props: true,
            meta: {
                auth: true
            }
        }
    ],
});

export default router;