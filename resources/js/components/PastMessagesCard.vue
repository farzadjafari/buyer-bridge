<template>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Past messages</h2>
        <div v-if="pastMessages.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="pastMessage in pastMessages"
                :key="pastMessage.id"
                :class="[
                        'shadow-md rounded-lg p-6 cursor-pointer transition duration-300 ease-in-out',
                        pastMessage.is_opened ? 'bg-white hover:shadow-lg' : 'bg-gray-200'
                    ]"
                @click="openMessage(pastMessage)"
            >
                <h2 class="text-xl font-semibold mb-2">Title: {{ pastMessage.title }}</h2>
                <p class="text-gray-700 mb-2">Body: {{ pastMessage.body }}</p>
                <p class="text-gray-700 mb-2">Opened: {{ pastMessage.is_opened }}</p>
                <small class="text-gray-600">Scheduled Opening Time: {{ pastMessage.scheduled_opening_time }}</small>

                <router-link :to="`/messages/update/${pastMessage.id}`"
                             class="mt-4 block text-center px-4 py-2 bg-green-500 text-white rounded-md">Update
                </router-link>
            </div>
        </div>

        <div v-else>
            <p>You do not have any messages yet. Create one!</p>
        </div>
    </div>
</template>

<script>
import axios from "../axios.js";

export default {
    props: {
        pastMessages: {
            type: Array,
            required: true
        }
    },
    methods: {
        openMessage(message) {
            if (!message.is_opened) {
                axios.get(`api/messages/${message.id}`)
                    .then(response => {
                        message.is_opened = 1;
                        alert(`"${message.title}"!\n"${message.body}"`);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    }
}
</script>
