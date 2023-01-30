<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { onMounted, reactive, computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Pusher } from "@/pusher";

const props = defineProps({
    chats: [],
    sender: null,
});

const authUser = computed(() => usePage().props.value.user);

const state = reactive({
    chats: props.chats,
});

const form = useForm({
    message: "",
});

const sendMessage = () => {
    form.post(route("user.chat.store", { user: props.sender.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            window.location.reload();
        },
    });
};

const removeChatMessageById = (chatId) => {
    state.chats = state.chats.filter((chat) => chat.id != chatId);
};

const deleteChat = async (chatId) => {
    const form = useForm({});
    form.delete(route("chat.destroy", { chat: chatId }));

    removeChatMessageById(chatId);
};

onMounted(() => {
    const senderId = props.sender.id;
    const receiverId = authUser.value.id;

    Pusher.subscribe(`chat.sender.${senderId}.receiver.${receiverId}`)
        .bind("new-message", function ({ chat }) {
            state.chats.push(chat);
        })
        .bind("chat-message-deleted", function ({ chatId }) {
            removeChatMessageById(chatId);
        });
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
                    <template v-if="state.chats.length">
                        <ul class="px-6 py-2">
                            <li
                                v-for="chat in state.chats"
                                :key="chat.id"
                                class="py-1 flex justify-between"
                            >
                                <span>
                                    <strong>{{ chat.sender.name }} : </strong>
                                    <span class="ml-2">
                                        {{ chat.message }}
                                    </span>
                                </span>

                                <span v-if="authUser.id === chat.sender.id">
                                    <DangerButton @click="deleteChat(chat.id)"
                                        >X</DangerButton
                                    >
                                </span>
                            </li>
                        </ul>
                    </template>

                    <div class="px-6 pb-4 mt-4">
                        <form @submit.prevent="sendMessage" class="">
                            <div class="flex align-items-center">
                                <div class="w-1/2">
                                    <TextInput
                                        id="message"
                                        v-model="form.message"
                                        type="text"
                                        class="mt-1 block w-full"
                                        autocomplete="message"
                                        placeholder="Say something..."
                                    />
                                </div>

                                <PrimaryButton
                                    class="ml-2 w-32 flex items-center justify-center"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <span> Send </span>
                                    <span class="ml-1">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-5 h-5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
                                            />
                                        </svg>
                                    </span>
                                </PrimaryButton>
                            </div>

                            <InputError
                                :message="form.errors.message"
                                class="mt-2"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
