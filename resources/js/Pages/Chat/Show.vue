<template>
    <div class="flex">
        <div class="w-4/6">
            <div class="text-center text-xl font-bold mb-3">
                <h1>{{ chat.title ?? 'Your chat' }}</h1>
            </div>
            <div class="mr-5">
                <div class="mb-3 bg-violet-50 p-3 rounded-xl overflow-y-auto h-[50vh]">
                    <div class="" v-if="messages">
                        <div v-if="!isLastPage" class="text-center mx-2 mb-3 ">
                            <a @click.prevent="getMessages()" href="#"
                               class="p-1 bg-red-100 text-xs italic rounded-full hover:bg-red-200">
                                ... load more ...
                            </a>
                        </div>

                        <div v-for="message in messages.slice().reverse()" :class="message.is_owner ? '' : 'text-right'">
                            <div :class="['inline-block mb-2 p-1 rounded-lg',
                            message.is_owner ? 'bg-cyan-200 mr-12' : 'bg-green-200 ml-12'
                        ]">
                                <p class="italic text-xs text-left">{{message.user_name}}</p>
                                <p class="font-bold text-left">{{message.body}}</p>
                                <p class="italic text-xs text-right text-gray-400">{{message.time}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <div class="">
                            <input class="my-3 w-full rounded-full" type="text" placeholder="Your message" v-model="body">
                        </div>
                        <div class="">
                            <a @click.prevent="store()" href=""
                               class="border rounded-lg bg-sky-200 p-1 cursor-pointer font-bold hover:bg-sky-300">Send message
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-2/6">
            <div class="text-center text-xl font-bold mb-3">
                <h1>Users</h1>
            </div>
            <div v-if="users" class="overflow-y-auto h-[50vh]">
                <div class="flex mb-1 justify-between bg-violet-50 px-1 py-1 rounded-full" v-for="user in users">
                    <div class="flex overflow-hidden">
                        <div class="">
                            <p class="mr-2 bg-emerald-100 rounded-full px-2 ">
                                <span class="text-xs">id</span>{{user.id}}
                            </p>
                        </div>

                        <div class="">
                            <p class="">{{user.name}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/MainChat.vue";
import axios from "axios";

export default {
    name: "Show",

    props: [
        'chat',
        'users',
        'userIdsWithoutMe',
        'messages',
        'isLastPage'
    ],

    data() {
        return {
            body: '',
            page: 1,
        }
    },

     created() {
        window.Echo.channel('store-message-channel.' + this.chat.id)
            .listen('.store-message-broadcast-name', res => {
                res.message.is_owner = false;
                this.messages.unshift(res.message);
                this.body = '';
                if (this.$page.url === '/chats/' + this.chat.id) {
                    axios.patch('/update_message_statuses', {
                        message_id: res.message.id,
                        user_id: this.$page.props.auth.user.id
                    });
                }
            });
    },

    methods: {
        store() {
            axios.post('/messages', {
                chat_id: this.chat.id,
                body: this.body,
                userIdsWithoutMe: this.userIdsWithoutMe
            })
                .then(res => {
                    this.messages.unshift(res.data);
                    this.body = '';
                })
            ;
        },

        getMessages() {
            axios.get('/chats/' + this.chat.id + '?page=' + ++this.page)
                .then(res => {
                    this.messages.push(...res.data.messages)
                    this.$page.props.isLastPage = res.data.is_last_page
                });
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
