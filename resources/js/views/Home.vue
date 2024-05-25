<template>
    <div v-if="!authState.isLoggedIn">
        <div class="max-w-md mx-auto mt-10 p-8 bg-white shadow-md rounded-lg text-center">
            <h1 class="text-3xl font-bold mb-4">This is the BuyerBridge Assessment Project!</h1>
            <h2 class="text-xl text-gray-600">Please
                <router-link class="text-blue-400" to="/login">login</router-link>
                /
                <router-link class="text-blue-400" to="/register">register</router-link>
                to begin!
            </h2>
        </div>
    </div>

    <div v-else>
        <div class="max-w-md mx-auto mt-10 p-8 bg-white shadow-md rounded-lg text-center">
            <h1 class="text-3xl font-bold mb-4">Welcome!</h1>
            <router-link to="/messages" class="text-blue-400">Create a new Message Capsule!</router-link>
        </div>
    </div>


</template>

<script>
import {authState} from "../providers/auth.js";

export default {
    computed: {
        authState() {
            return authState;
        }
    }
}
</script>
