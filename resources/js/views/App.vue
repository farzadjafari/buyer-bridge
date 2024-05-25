<template>
    <div id="app" class="p-10">
        <div class="flex justify-between mb-10">
            <nav class="flex space-x-4">
                <router-link to="/">Home</router-link>
                <router-link v-if="authState.isLoggedIn" to="/messages">Messages</router-link>
            </nav>
            <nav class="flex flex-row-reverse space-x-4 space-x-reverse">
                <router-link v-if="!authState.isLoggedIn" to="/register">Register</router-link>
                <router-link v-if="!authState.isLoggedIn" to="/login">Login</router-link>
                <button v-if="authState.isLoggedIn" @click="handleLogout">Logout</button>
            </nav>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
import { authState, logout } from "../providers/auth";

export default {
    name: 'App',
    computed: {
        authState() {
            return authState;
        }
    },
    methods: {
        handleLogout() {
            logout();
            this.$router.push('/');
        }
    }
}
</script>
