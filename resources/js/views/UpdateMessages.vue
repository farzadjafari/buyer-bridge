<template>
    <div class="max-w-md mx-auto mt-10 p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Update Message</h1>
        <form @submit.prevent="updateMessage" class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" v-model="title" id="title"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <small v-if="errors.title" class="mt-1 text-red-500">
                    {{ errors.title[0] }}
                </small>
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <textarea v-model="body" id="body"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                <small v-if="errors.body" class="mt-1 text-red-500">
                    {{ errors.body[0] }}
                </small>
            </div>
            <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update
            </button>
        </form>
    </div>
</template>

<script>
import axios from '../axios';

export default {
    data() {
        return {
            id: this.$route.params.id,
            title: '',
            body: '',
            errors: {}
        };
    },
    created() {
        this.fetchMessage();
    },
    methods: {
        fetchMessage() {
            axios.get(`/api/messages/${this.id}`)
                .then(response => {
                    this.title = response.data.data.title;
                    this.body = response.data.data.body;
                })
                .catch(error => {
                    console.error('Error fetching message:', error);
                });
        },
        updateMessage() {
            axios.put(`/api/messages/${this.id}`, {
                title: this.title,
                body: this.body,
            })
                .then(response => {
                    this.$router.push('/messages');
                })
                .catch(({response}) => {
                    this.errors = response.data.errors;
                });
        }
    }
};
</script>
