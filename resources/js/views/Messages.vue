<template>
    <div class="max-w-4xl mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Your Messages</h1>

        <CapsuleMessages :capsule-messages="capsuleMessages"/>

        <PastMessages :past-messages="pastMessages" class="mt-10"/>

        <MessageForm @messageCreated="handleMessageCreated" class="mt-10"></MessageForm>

        <div v-if="error" class="mt-4 text-red-500">
            {{ error }}
        </div>
    </div>
</template>

<script>
import axios from '../axios';
import MessageForm from "../components/MessageForm.vue";
import CapsuleMessages from "../components/CapsuleMessages.vue";
import PastMessages from "../components/PastMessages.vue";

export default {
    components: {
        PastMessages,
        CapsuleMessages,
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
        handleMessageCreated(message) {
            if (message.is_past) {
                this.pastMessages.push(message);
            } else {
                this.capsuleMessages.push(message);
            }
        }
    }
};
</script>

