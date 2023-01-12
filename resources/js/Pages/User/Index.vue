<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
    users: [],
});
</script>

<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <template v-if="users.length">
                        <ul class="px-6 py-2">
                            <li
                            v-for="user in users"
                            :key="users.id"
                            class="py-1"
                            >
                                <Link :href="route('user.chat.index', { 'user': user.id })">
                                    {{ user.name }}
                                </Link>
                            </li>
                        </ul>
                    </template>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
