<template>
    <div class="max-w-4xl mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Your Messages</h1>

        <div>
            <h2 class="text-2xl font-semibold mb-4">Capsule messages</h2>
            <div v-if="capsuleMessages.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="capsuleMessage in capsuleMessages" :key="capsuleMessage.id" class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-2">Title: {{ capsuleMessage.title }}</h2>
                    <small class="text-gray-600">Scheduled Opening Time: {{ capsuleMessage.scheduled_opening_time }}</small>
                </div>
            </div>
            <div v-else>
                <p>You do not have any messages yet. Create one!</p>
            </div>
        </div>

        <div class="mt-10">
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
                </div>
            </div>

            <div v-else>
                <p>You do not have any messages yet. Create one!</p>
            </div>
        </div>

        <message-form @messageCreated="handleMessageCreated" class="mt-10"></message-form>

        <div v-if="error" class="mt-4 text-red-500">
            {{ error }}
        </div>
    </div>
</template>

<script>
import axios from '../axios';
import MessageForm from "../components/MessageForm.vue";

export default {
    components: {
        MessageForm
    },
    data() {
        return {
            capsuleMessages: [],
            pastMessages: [],
            error: null,
        };
    },
    created() {
        this.fetchCapsuleMessages();
        this.fetchPastMessages();
    },
    methods: {
        fetchCapsuleMessages() {
            axios.get('api/capsule/messages')
                .then(response => {
                    this.capsuleMessages = response.data.data;
                    this.error = null;
                })
                .catch(error => {
                    this.error = 'Failed to load messages. Please try again later.';
                });
        },
        fetchPastMessages() {
            axios.get('api/past/messages')
                .then(response => {
                    this.pastMessages = response.data.data;
                    this.error = null;
                })
                .catch(error => {
                    this.error = 'Failed to load messages. Please try again later.';
                });
        },
        handleMessageCreated() {
            this.fetchCapsuleMessages();
            this.fetchPastMessages();
        },
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
};
</script>

