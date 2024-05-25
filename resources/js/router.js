import { createRouter, createWebHistory } from "vue-router";
import Home from './views/Home.vue';
import Messages from './views/Messages.vue';
import Register from './views/Register.vue';
import Login from './views/Login.vue';
import { authState } from "./providers/auth.js";
import UpdateMessages from "./views/UpdateMessages.vue";

let routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/messages',
        name: 'Messages',
        component: Messages,
        beforeEnter: (to, from, next) => {
            if (!authState.isLoggedIn) {
                next('/login');
            } else {
                next();
            }
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/messages/update/:id',
        name: 'UpdateMessage',
        component: UpdateMessages
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
