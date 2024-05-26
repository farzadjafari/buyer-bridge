<template>
    <div class="capsule-messages">
        <h2 class="text-2xl font-semibold mb-4">Capsule messages</h2>
        <div v-if="capsuleMessages.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="capsuleMessage in capsuleMessages" :key="capsuleMessage.id"
                 class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-2">Title: {{ capsuleMessage.title }}</h2>
                <small class="text-gray-600">Scheduled Opening Time: {{ capsuleMessage.scheduled_opening_time }}</small>
            </div>
        </div>
        <div v-else>
            <p>You do not have any messages yet. Create one!</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        capsuleMessages: {
            type: Array,
            required: true
        }
    }
}
</script>
