<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <h1>Chat List</h1>
            </div>
            <div class="mr-5" v-if="chats">
                <div class="inline-block w-full" v-for="chat in chats">
                    <Link :href="route('chats.show', chat.id)">
                        <div class="mb-3 bg-violet-50 p-3 rounded-full overflow-hidden">
                            <div class="flex justify-between items-center">
                                <div class="inline-block w-full">
                                    <div class="flex">
                                        <div class="flex my-1">
                                            <p class="mr-2 bg-emerald-100 rounded-full px-2">
                                                <span class="text-xs">id</span>
                                                {{chat.id}}
                                            </p>
                                            <p class="font-bold">{{chat.title}}</p>
                                        </div>
                                    </div>
                                    <div class="mx-11 bg-red-100 text-xs italic rounded-full px-2 flex justify-between text-gray-400">
                                        <div class="flex">
                                            <div>
                                                Last message
                                            </div>
                                            <div class="mx-1 text-gray-900 font-bold">
                                                "{{chat.last_message.body}}"
                                            </div>
                                            <div>
                                                from
                                            </div>
                                            <div class="mx-1 text-gray-900 font-bold">
                                                {{chat.last_message.user_name}}
                                            </div>
                                        </div>

                                        <div class="text-gray-400 ml-8 text-xs">
                                            {{chat.last_message.time}}
                                        </div>
                                    </div>
                                </div>

                                <div class="mr-5 bg-red-400 rounded-full px-2" v-if="chat.unreadable_message_count !== 0">
                                    <p>{{chat.unreadable_message_count}}</p>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
            <div v-else class="mb-3 mr-5 bg-violet-50 p-3 rounded-full">No chats yet...</div>
        </div>

        <div class="w-1/4 border-gray-600">
            <div class="text-center text-xl font-bold mb-3">
                <h1>Users</h1>
            </div>

            <div class="text-right my-2">
                <a @click.prevent="isGroup = true" v-if="!isGroup" class="border rounded-lg bg-sky-200 p-1 cursor-pointer font-bold">Make group</a>
            </div>

            <div v-if="isGroup">
                <div class="my-2">
                    <a @click.prevent="storeGroup()" class="border rounded-lg bg-green-200 p-1 cursor-pointer font-bold">Make group</a>
                    <a @click.prevent="refreshUserIds()" class="border rounded-lg bg-green-200 p-1 ml-2 cursor-pointer">&#10008;</a>
                    <input class="my-3 w-full rounded-full" type="text" placeholder="Group chat title" v-model="title">
                </div>
            </div>

            <div v-if="users">
                <div class="flex mb-1 justify-between bg-violet-50 px-1 py-1 rounded-full" v-for="user in users">
                    <div class="flex overflow-hidden">
                        <div v-if="isGroup" class="">
                            <input @click="toogleUsers(user.id)" type="checkbox" class="rounded-sm ml-1 mr-2">
                        </div>

                        <div class="">
                            <p class="mr-2 bg-emerald-100 rounded-full px-2 ">
                                <span class="text-xs">id</span>{{user.id}}
                            </p>
                        </div>

                        <div class="">
                            <p class="">{{user.name}}</p>
                        </div>

                    </div>
                    <div class="">
                        <a @click.prevent="store(user.id)" class="inline-block border rounded-lg bg-indigo-400 ml-2 px-2 cursor-pointer">&#9993;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
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
