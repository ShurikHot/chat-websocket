<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class=""><h1>Single Theme</h1></div>
                    <div class="" v-if="theme">
                        <div class="text-red-600">{{ theme.title }}</div>
                        <div class="text-xs ml-2 -mt-2 text-gray-500">
                            {{ theme.description }}
                        </div>
                    </div>

                    <div class="mt-5" v-if="messages.length > 0">
                        <h1>Messages</h1>

                        <div class="text-sm mx-3 mb-1 flex items-center" v-for="message in messages">
                            <div class="w-10 h-10 ">
                                <img :src="message.avatar" alt="">
                            </div>
                            <div class="italic mr-2">
                                {{ message.user.name}}
                            </div>
                            <div class="mr-2">
                                {{ message.content }}
                            </div>
                            <div class="">
                                {{ message.time }}
                            </div>
                            <div class="">
                                <a href="#" @click.prevent="like(message.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                    </svg>
                                </a>
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 0 1-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 0 0 7.5 19.75 2.25 2.25 0 0 0 9.75 22a.75.75 0 0 0 .75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 0 0 2.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384m-10.253 1.5H9.7m8.075-9.75c.01.05.027.1.05.148.593 1.2.925 2.55.925 3.977 0 1.487-.36 2.89-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398-.306.774-1.086 1.227-1.918 1.227h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 0 0 .303-.54" />
                                </svg>-->
                            </div>
                        </div>
                    </div>

                    <div class="mt-5" v-if="messages.length > 0">
                        <button @click.prevent="firstPage()" :disabled="page == 1" class="border p-2 rounded-lg mr-2">First</button>
                        <button @click.prevent="previousPage()" :disabled="page == 1" class="border p-2 rounded-lg mr-2">Previous</button>
                        <button @click.prevent="nextPage()" :disabled="isLastPage" class="border p-2 rounded-lg mr-2">Next</button>
                        <button @click.prevent="lastPage()" :disabled="isLastPage" class="border p-2 rounded-lg mr-2">Last</button>
                    </div>

                    <div class="mt-5">
                        <h1>Add message</h1>
                        <div class="bg-gray-200 w-full rounded-lg px-3 py-2 mb-3" ref="message" contenteditable="true"></div>
                        <a @click.prevent="store()" href="#" class="bg-red-200 rounded-lg ml-4 py-1 px-3">Send message</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/MainForum.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Show",

    components: {
        Link
    },

    props: [
        'theme',
        'messages',
        'isLastPage',
        'currentPage',
        'last',
        'perPage'
    ],

    data() {
        return {
            page: this.currentPage,
        }
    },

    methods: {
        store() {
            axios.post('/fmessages', {
                theme_id: this.theme.id,
                content: this.$refs.message.innerHTML,
            })
                .then(res => {
                    this.$refs.message.innerHTML = ''
                    this.messages.push(res.data)
                    if (this.messages.length > this.perPage) {
                        this.nextPage()
                    }
                });
        },

        like(messageId) {
            console.log(messageId);
        },

        nextPage() {
            this.$inertia.get('/themes/' + this.theme.id + '?page=' + ++this.page)
        },

        previousPage() {
            this.$inertia.get('/themes/' + this.theme.id + '?page=' + --this.page)
        },

        firstPage() {
            this.$inertia.get('/themes/' + this.theme.id + '?page=1')
        },

        lastPage() {
            this.$inertia.get('/themes/' + this.theme.id + '?page=' + this.last)
        }

    },

    layout: Main
}
</script>

<style scoped>

</style>
