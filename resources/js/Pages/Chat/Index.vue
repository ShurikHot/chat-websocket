<template>
    <div class="flex">
        <div class="w-4/6">
            <div class="text-center text-xl font-bold mb-3">
                <h1>Chat List</h1>
            </div>
            <div class="mr-5 h-[50vh]" v-if="chats.length > 0">
                <div class="inline-block w-full overflow-y-auto" v-for="chat in chats">
                    <Link :href="route('chats.show', chat.id)">
                        <div class="mb-3 bg-violet-50 p-3 rounded-full overflow-hidden hover:bg-violet-200">
                            <div class="flex justify-between items-center">
                                <div class="inline-block w-full">
                                    <div class="flex">
                                        <div class="flex my-1">
                                            <p class="mr-2 bg-emerald-100 rounded-full px-2">
                                                <span class="text-xs">id</span>{{ chat.id }}
                                            </p>
                                            <p class="font-bold">{{ chat.title }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="mx-11 bg-red-100 text-xs italic rounded-full px-2 flex justify-between text-gray-400">
                                        <div class="flex">
                                            <div>
                                                Last message
                                            </div>
                                            <div class="mx-1 text-gray-900 font-bold">
                                                "{{ chat.last_message.body }}"
                                            </div>
                                            <div>
                                                from
                                            </div>
                                            <div class="mx-1 text-gray-900 font-bold">
                                                {{ chat.last_message.user_name }}
                                            </div>
                                        </div>

                                        <div class="text-gray-400 ml-8 text-xs">
                                            {{ chat.last_message.time }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mr-5 bg-red-400 rounded-full px-2"
                                     v-if="chat.unreadable_message_count !== 0">
                                    <p>{{ chat.unreadable_message_count }}</p>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
            <div v-else class="mb-3 mr-5 bg-violet-50 p-3 rounded-full">No chats yet...</div>
        </div>

        <div class="w-2/6 border-gray-600">
            <div class="text-center text-xl font-bold mb-3">
                <h1>Users</h1>
            </div>

            <div class="" v-if="users.length > 0">
                <div class="text-right my-2">
                    <a @click.prevent="isGroup = true" v-if="!isGroup"
                       class="border rounded-lg bg-sky-200 p-1 cursor-pointer font-bold hover:bg-sky-300">Make group</a>
                </div>

                <div v-if="isGroup">
                    <div class="my-2">
                        <a @click.prevent="storeGroup()"
                           class="border rounded-lg bg-green-200 p-1 cursor-pointer font-bold hover:bg-green-300">Make
                            group
                        </a>
                        <a @click.prevent="refreshUserIds()"
                           class="border rounded-lg bg-green-200 p-1 ml-2 cursor-pointer hover:bg-green-300">&#10008;
                        </a>
                        <input class="my-3 w-full rounded-full" type="text" placeholder="Group chat title"
                               v-model="title">
                    </div>
                </div>
            </div>

            <div class="mb-3 mr-5 bg-violet-50 p-3 rounded-full" v-else>No users yet...</div>

            <div v-if="users" class=" overflow-y-auto h-[50vh]">
                <div
                    class="flex mb-1 justify-between bg-violet-50 px-1 py-1 rounded-lg hover:bg-violet-200 items-center"
                    v-for="user in users">
                    <div class="flex overflow-hidden">
                        <div v-if="isGroup" class="">
                            <input @click="toogleUsers(user.id)" type="checkbox" class="rounded-sm ml-1 mr-2">
                        </div>

                        <div class="flex items-center">
                            <p class="mr-1 bg-emerald-100 rounded-full px-2">
                                <span class="text-xs">id</span>{{ user.id }}
                            </p>
                            <img :src="user.avatar" alt="" class="mr-2 w-5 h-5">
                        </div>

                        <div class="overflow-hidden max-w-[25vh]">
                            {{ user.name }}
                        </div>

                    </div>
                    <div class="flex">
                        <a @click.prevent="store(user.id)"
                           class="inline-block border rounded-lg bg-indigo-300 ml-2 px-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/MainChat.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Index",

    components: {
        Link
    },

    props: [
        'users',
        'chats'
    ],

    data() {
        return {
            isGroup: false,
            userIds: [],
            title: null
        }
    },

    created() {
        window.Echo.channel('users-channel.' + this.$page.props.auth.user.id)
            .listen('.store-message-status-broadcast-name', res => {
                this.chats.filter(chat => {
                    if (chat.id === res.chat_id) {
                        chat.unreadable_message_count = res.count
                        chat.last_message = res.message
                    }
                });
            });
    },

    methods: {
        store(id) {
            this.$inertia.post('/chats', {title: null, users: [id]});
        },

        storeGroup() {
            this.$inertia.post('/chats', {title: this.title, users: this.userIds});
        },

        toogleUsers(id) {
            let index = this.userIds.indexOf(id)
            if (index === -1) {
                this.userIds.push(id);
            } else {
                this.userIds.splice(index, 1)
            }
        },

        refreshUserIds() {
            this.userIds = [];
            this.isGroup = false
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
