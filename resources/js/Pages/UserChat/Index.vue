<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

defineProps({
    chats: [],
});
</script>

<template>
    <AppLayout title="Chat">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <template v-if="chats.length">
                        <ul class="px-6 py-2">
                            <li v-for="chat in chats" :key="chat.id" class="py-1">
                                <strong>{{ chat.sender.name }} : </strong>
                                <span class="ml-2">
                                    {{ chat.message }}
                                </span>
                            </li>
                        </ul>
                    </template>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
