<template>
    <div class="max-w-md mx-auto mt-10 p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
        <form @submit.prevent="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" v-model="email" id="email"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <small v-if="errors.email" class="mt-1 text-red-500">
                    {{ errors.email[0] }}
                </small>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" v-model="password" id="password"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <small v-if="errors.password" class="mt-1 text-red-500">
                    {{ errors.password[0] }}
                </small>
            </div>

            <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Login
            </button>
        </form>
    </div>
</template>

<script>
import {login as loginUser} from "../providers/auth.js";

export default {
    data() {
        return {
            email: '',
            password: '',
            errors: {},
        };
    },
    methods: {
        login() {
            axios.post('/api/login', {
                email: this.email,
                password: this.password
            }).then(response => {
                loginUser(response.data.token);
                this.$router.push('/messages');
            }).catch(({response}) => {
                this.errors = response.data.errors;
            });
        }
    }
}
</script>
