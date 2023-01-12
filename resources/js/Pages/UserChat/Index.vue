<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { onMounted,reactive,computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3'
import { Pusher } from '@/pusher'

const props = defineProps({
    chats: [],
    sender: null
});

const authUser = computed(() => usePage().props.value.user)

const state = reactive({
    chats: props.chats,
})

const form = useForm({
    message: '',
})

const sendMessage = async () => {
    form.post(`/users/${props.sender.id}/chats`)
    form.reset()
    window.location.reload()
}

onMounted(() => {
    const senderId = props.sender.id
    const receiverId = authUser.value.id

    Pusher.subscribe(`chat.sender.${senderId}.receiver.${receiverId}`)
        .bind('new-message',function ({ chat }) {
            state.chats.push(chat)
        })
})
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

                    <template v-if="state.chats.length">
                        <ul class="px-6 py-2">
                            <li v-for="chat in state.chats" :key="chat.id" class="py-1">
                                <strong>{{ chat.sender.name }} : </strong>
                                <span class="ml-2">
                                    {{ chat.message }}
                                </span>
                            </li>
                        </ul>
                    </template>

                    <div class="px-6 pb-4 mt-4">
                        <form @submit.prevent="sendMessage" class="flex align-items-center">
                            <div class="w-1/2">
                                <TextInput id="message" v-model="form.message" type="text" class="mt-1 block w-full"
                                    autocomplete="message" placeholder="Say something..." />
                                <InputError :message="form.errors.message" class="mt-2" />
                            </div>

                            <PrimaryButton class="ml-2 w-32" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Send
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
