<template>
    <div class="flex">
        <div class="w-full">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class="" v-if="theme">
                        <div class="text-red-600">{{ theme.title }}</div>
                        <div class="text-xs ml-2 -mt-2 text-gray-500">
                            {{ theme.description }}
                        </div>
                    </div>

                    <div class="mt-5" v-if="messages.length > 0">
                        <div class="" v-for="message in messages" :id="message.id">
                            <div class="flex items-center items-stretch mt-3">
                                <div class="border px-7 py-2 bg-gray-200 text-center rounded-lg rounded-r-none">
                                    <div class="w-12 h-12 m-auto">
                                        <img :src="message.avatar" alt="">
                                    </div>
                                    <div class="italic text-base text-red-800 font-bold mt-2">
                                        {{ message.user.name }}
                                    </div>
                                    <div class="text-xs text-indigo-300 animate-bounce" v-if="message.user.id !== $page.props.auth.user.id">
                                        <a @click.prevent="goChat(message.user.id)" href="" class="">Go chat!</a>
                                    </div>
                                </div>
                                <div class="border px-5 pt-2 pb-1 w-full rounded-lg rounded-l-none">
                                    <div class="flex items-center justify-between border border-dotted border-x-0 border-t-0">
                                        <div class="text-xs italic text-gray-400">
                                            {{ message.time }}
                                        </div>
                                        <div class="text-xs text-gray-300">
                                            #{{ message.id }}
                                        </div>
                                    </div>

                                    <div class="mr-2 mt-2 text-base" v-html="message.content"></div>

                                    <div class="flex items-center justify-between mt-5 pt-1 border border-dotted border-x-0 border-b-0">
                                        <div class="">
                                            <div class="text-sm text-violet-700 animate-pulse mt-2" @click.prevent="isComplaint(message)">
                                                <a href="">Complaint</a>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <div class="flex items-center pr-2 ml-2 mr-6">
                                                <div class="mr-1 rounded-full bg-red-100 px-4 py-0 text-base" v-if="message.liked_users.length">
                                                    {{ message.liked_users.length }}
                                                </div>
                                                <a href="#" @click.prevent="like(message)"
                                                   :class="['',
                                                    message.user.id === $page.props.auth.user.id ? 'opacity-50 cursor-not-allowed' : ''
                                                    ]
                                                ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" :fill="message.is_liked ? 'red' : ''"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                         :class="['size-6',
                                                         message.is_liked || (!message.is_liked && message.user.id === $page.props.auth.user.id) ? '' : 'animate-bounce relative top-1'
                                                         ]">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z"/>
                                                    </svg>
                                                </a>
                                            </div>


                                            <div class="text-sm text-lime-700 animate-pulse mr-3" @click.prevent="quote(message)">
                                                <a href="">+Quote</a>
                                            </div>

                                            <div class="text-sm text-teal-700 animate-pulse flex items-center" @click.prevent="answer(message)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 mr-1 ml-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                                </svg>
                                                <a href="">
                                                    Answer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex" v-if="message.is_complaint" >
                                <input placeholder="  Your complaint" class="border border-gray-200 p-1 w-full rounded-lg rounded-r-none" v-model="message.body">
                                <button @click="complaint(message)" class="text-base bg-violet-300 rounded-lg rounded-l-none border p-1">Send</button>
                            </div>

                            <div class="text-sm text-center border bg-pink-200 mb-4 rounded-lg" v-if="!message.is_solved">
                                &#8593;Your complaint is under consideration&#8593;
                            </div>
                        </div>
                    </div>

                    <div class="mt-5" v-else>No messages yet...</div>

                    <div class="mt-5 mx-auto flex items-center justify-center" v-if="messages.length > 0">
                        <button @click.prevent="firstPage()" :disabled="page == 1" class="bg-sky-100 border py-1 px-2 rounded-lg mr-2">First</button>
                        <button @click.prevent="previousPage()" :disabled="page == 1" class="bg-sky-300 border py-1 px-2 rounded-lg mr-2">Previous</button>
                        <button @click.prevent="nextPage()" :disabled="isLastPage" class="bg-sky-300 border py-1 px-2 rounded-lg mr-2">Next</button>
                        <button @click.prevent="lastPage()" :disabled="isLastPage" class="bg-sky-100 border py-1 px-2 rounded-lg mr-2">Last</button>
                    </div>

                    <div class="mt-6">
                        <div class="flex items-center items-stretch mt-3">
                            <div class="border px-7 py-2 bg-gray-200 rounded-lg rounded-r-none">
                                <div class="w-12 h-12 m-auto">
                                    <img :src="theme.auth_user_avatar" alt="">
                                </div>
                                <div class="italic text-base text-center text-red-800 font-bold mt-2">
                                    {{ $page.props.auth.user.name }}
                                </div>
                            </div>

                            <div class="border px-5 pt-2 pb-1 w-full rounded-lg rounded-l-none">
                                <div class="mb-1">
                                    <div class="bg-gray-200 w-full rounded-lg px-1 py-1 mb-3 mx-1 flex justify-between" ref="tools">
                                        <div class="flex">
                                            <a href="" @click.prevent="setBold(this.$refs.message.innerHTML)">
                                                <p class=""><span class="border border-gray-800 px-2 mx-2">B</span></p>
                                            </a>
                                            <a href="" @click.prevent="setItalic(this.$refs.message.innerHTML)">
                                                <p class="italic"><span class="border border-gray-800 px-2.5 mr-2">I</span></p>
                                            </a>
                                            <a href="" @click.prevent="setUnderline(this.$refs.message.innerHTML)">
                                                <p class="underline"><span class="border border-gray-800 px-2 mr-2">U</span></p>
                                            </a>
                                        </div>
                                        <div class="text-gray-300 italic mr-3">
                                            Tools Bar
                                        </div>
                                    </div>

                                    <div class="text-xs italic text-gray-400">
                                        <div class="flex items-center ml-4 mb-2">
                                            <div class="mr-1 text-gray-500" v-html="answer_content"></div>
                                            <div class="mr-1 text-gray-500" v-html="quote_content"></div>
                                            <a href="" @click.prevent="clearQuoteAnswer()">
                                                <div class="" v-if="answer_content !== '' || quote_content !== ''">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24"
                                                         stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="bg-gray-200 w-full rounded-lg px-3 py-2 mb-3 mx-1 font-normal" ref="message" contenteditable="true"></div>
                                    <div class="flex justify-end">
                                        <a @click.prevent="store()" href="#" class="bg-indigo-300 rounded-lg ml-3 py-1 px-3">Send message</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/MainForum.vue";
import {Link, usePage} from "@inertiajs/vue3";
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
            answer_content: '',
            quote_content: '',
            answer_user_id: null,
        }
    },

    created() {
        const page = usePage();
        const currentRoute = page.url;
        if (currentRoute.includes('?page=') && !this.messages.length) {
            this.lastPage()
        }

        window.Echo.channel('store-forum-message.' + this.theme.id)
            .listen('.store-forum-message-broadcast-name', res => {
                this.messages.push(res.message)
            });
    },

    methods: {
        store() {
            axios.post('/fmessages', {
                theme_id: this.theme.id,
                content: this.answer_content + this.quote_content + this.$refs.message.innerHTML,
            })
                .then(res => {
                    if (this.answer_user_id !== null) {
                        axios.post('/fmessages/' + this.answer_user_id + '/answer', {
                            id: res.data.id,
                            theme_id: res.data.theme_id,
                            user_id: this.answer_user_id
                        })
                        this.answer_user_id = null
                    }
                    this.clearQuoteAnswer()
                    this.$refs.message.innerHTML = ''
                    // this.messages.push(res.data)
                    if (this.messages.length > this.perPage) {
                        this.nextPage()
                    }
                });
        },

        like(message) {
            axios.post('/fmessages/' + message.id + '/likes')
                .then(res => {
                    message.is_liked = !message.is_liked;
                    message.is_liked ? message.liked_users.length++ : message.liked_users.length--
                });
        },

        answer(message) {
            this.quote_content = '';
            this.answer_user_id = message.user.id
            this.answer_content = `<div class="text-sm select-none ml-5">
                        <span class="text-gray-300 italic">
                            Answer to message from
                        </span>
                        <span class="text-gray-400">
                            ${message.user.name}:
                        </span>
                        <span class="text-gray-300">
                            ${message.content}
                        </span>
                        <span class="text-gray-200">
                            (${message.time}):
                        </span>
                    </div>`
            this.$refs.message.focus()
        },

        quote(message) {
            this.answer_content = '';
            if (window.getSelection().toString()) {

                const content = window.getSelection().toString();
                if (!message.content.includes(content)) return

                this.quote_content = `<div class="text-sm select-none ml-5">
                        <span class="text-gray-300 italic">
                            Quote message from
                        </span>
                        <span class="text-gray-400">
                            ${message.user.name}:
                        </span>
                        <span class="text-gray-300">
                            ${content}
                        </span>
                        <span class="text-gray-200">
                            (${message.time}):
                        </span>
                    </div>`
            }
            this.$refs.message.focus()
        },

        isComplaint(message) {
            message.body = ''
            message.is_complaint = !message.is_complaint;
        },

        complaint(message) {
            axios.post(`/fmessages/${message.id}/complaint`, {
                'theme_id': this.theme.id,
                'body': message.body
            })
                .then( res => {
                    this.isComplaint(message)
                    message.is_solved = res.data.is_solved
                });

        },

        clearQuoteAnswer() {
            this.answer_content = ''
            this.quote_content = ''
        },

        goChat(id) {
            this.$inertia.post('/chats', {title: null, users: [id]});
        },

        setBold(message) {
            this.modifyFont('strong', message)
        },

        setItalic(message) {
            this.modifyFont('i', message)
        },

        setUnderline(message) {
            this.modifyFont('u', message)
        },

        modifyFont(type, message) {
            if (!window.getSelection().toString() || !message.includes(window.getSelection().toString())) return

            const range = window.getSelection().getRangeAt(0)
            const typeOfModify = document.createElement(type)

            range.surroundContents(typeOfModify)
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
