<template>
    <div class="max-w-md p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6">Make a time capsule with a message.</h1>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Message title</label>
                <input type="text" name="title" id="title" v-model="title"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <small v-if="errors.title" class="mt-1 text-red-500">
                    {{ errors.title[0] }}
                </small>
            </div>

            <div>
                <label for="body" class="block text-sm font-medium text-gray-700">Message body</label>
                <textarea name="body" id="body" v-model="body"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                <small v-if="errors.body" class="mt-1 text-red-500">
                    {{ errors.body[0] }}
                </small>
            </div>

            <div>
                <label for="time" class="block text-sm font-medium text-gray-700">Scheduled Opening Time</label>
                <input type="date" name="scheduled_opening_time" id="time" v-model="scheduledOpeningTime"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <small v-if="errors.scheduled_opening_time" class="mt-1 text-red-500">
                    {{ errors.scheduled_opening_time[0] }}
                </small>
            </div>

            <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit
            </button>
        </form>
    </div>

</template>

<script>
import axios from '../axios.js';

export default {
    emits: ['messageCreated'],
    data() {
        return {
            title: '',
            body: '',
            scheduledOpeningTime: '',
            errors: {},
        }
    },
    methods: {
        submit() {
            const payload = {
                title: this.title,
                body: this.body,
                scheduled_opening_time: this.scheduledOpeningTime
            };

            axios.post('api/messages', payload)
                .then(response => {
                    this.$emit('messageCreated', response.data.data);
                    this.resetForm();
                    this.errors = {};
                })
                .catch(({response}) => {
                    this.errors = response.data.errors;
                })
        },
        resetForm() {
            this.title = '';
            this.body = '';
            this.scheduledOpeningTime = '';
            this.errors = {};
        }
    }
}
</script>
