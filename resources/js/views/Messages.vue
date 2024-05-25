<template>
    <div class="max-w-4xl mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Your Messages</h1>

        <CapsuleMessagesCard :capsule-messages="capsuleMessages"/>

        <PastMessagesCard :past-messages="pastMessages" class="mt-10"/>

        <message-form @messageCreated="handleMessageCreated" class="mt-10"></message-form>

        <div v-if="error" class="mt-4 text-red-500">
            {{ error }}
        </div>
    </div>
</template>

<script>
import axios from '../axios';
import MessageForm from "../components/MessageForm.vue";
import CapsuleMessagesCard from "../components/CapsuleMessagesCard.vue";
import PastMessagesCard from "../components/PastMessagesCard.vue";

export default {
    components: {
        PastMessagesCard,
        CapsuleMessagesCard,
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
        }
    }
};
</script>

