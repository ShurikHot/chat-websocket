<template>
    <div class="flex">
        <div class="w-full">
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

                        <div class="" v-for="message in messages">
                            <div class="text-sm mx-3 mb-1 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 ">
                                        <img :src="message.avatar" alt="">
                                    </div>
                                    <div class="italic mr-2">
                                        {{ message.user.name }}
                                    </div>
                                    <div class="mr-2" v-html="message.content"></div>

                                </div>

                                <div class="flex items-center">
                                    <div class="">
                                        {{ message.time }}
                                    </div>
                                    <div class="flex items-center border pr-2 ml-2">
                                        <a href="#" @click.prevent="like(message)">
                                            <svg xmlns="http://www.w3.org/2000/svg" :fill="message.is_liked ? 'red' : ''"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2 size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z"/>
                                            </svg>
                                        </a>
                                        <div class="ml-3 rounded-full bg-red-100 px-3 py-1">
                                            {{ message.liked_users.length }}
                                        </div>
                                    </div>

                                    <div class="border mx-2" @click.prevent="isComplaint(message)">
                                        <a href="">Complaint</a>
                                    </div>

                                    <div class="border mx-2" @click.prevent="quote(message)">
                                        <a href="">Quote</a>
                                    </div>

                                    <div class="border mx-2" @click.prevent="answer(message)">
                                        <a href="">Answer</a>
                                    </div>
                                </div>
                            </div>

                            <div class="flex" v-if="message.is_complaint" >
                                <input placeholder="Your complaint" class="border border-gray-700 p-1 w-full rounded-lg rounded-r-none" v-model="message.body">
                                <button @click="complaint(message)" class="rounded-lg rounded-l-none border border-gray-700 p-1">Send</button>
                            </div>

                            <div class="text-xs text-center border bg-pink-100 mb-4 -mt-2" v-if="!message.is_solved">
                                &#8593;Your complaint is under consideration&#8593;
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 mx-3" v-if="messages.length > 0">
                        <button @click.prevent="firstPage()" :disabled="page == 1" class="border p-2 rounded-lg mr-2">First</button>
                        <button @click.prevent="previousPage()" :disabled="page == 1" class="border p-2 rounded-lg mr-2">Previous</button>
                        <button @click.prevent="nextPage()" :disabled="isLastPage" class="border p-2 rounded-lg mr-2">Next</button>
                        <button @click.prevent="lastPage()" :disabled="isLastPage" class="border p-2 rounded-lg mr-2">Last</button>
                    </div>

                    <div class="mt-5">
                        <h1>Add message</h1>
                        <div class="flex items-center">
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


                        <div class="bg-gray-200 w-full rounded-lg px-1 py-1 mb-3 mx-3 flex justify-between" ref="tools">
                            <div class="flex">
                                <a href="" @click.prevent="setBold(this.$refs.message.innerHTML)">
                                    <p class=""><span class="border border-gray-800 px-2 mr-2">B</span></p>
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

                        <div class="bg-gray-200 w-full rounded-lg px-3 py-2 mb-3 mx-3 font-normal" ref="message" contenteditable="true"></div>
                        <a @click.prevent="store()" href="#" class="bg-red-200 rounded-lg ml-3 py-1 px-3">Send message</a>
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
            answer_content: '',
            quote_content: '',
            id_answer: null,
        }
    },

    methods: {
        store() {
            axios.post('/fmessages', {
                theme_id: this.theme.id,
                content: this.answer_content + this.quote_content + this.$refs.message.innerHTML,
            })
                .then(res => {
                    /*if (id_answer !== null) {
                        this.$inertia.post('/fmessages/' + this.id_answer + '/answer');
                    }*/
                    this.clearQuoteAnswer()
                    this.$refs.message.innerHTML = ''
                    this.messages.push(res.data)
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
            this.id_answer = message.user.id
            this.answer_content = `<div class="text-sm select-none">
                        <span class="text-gray-500 italic">
                            Answer to message from
                        </span>
                        <span class="">
                            ${message.user.name}:
                        </span>
                        <span class="">
                            ${message.content}
                        </span>
                        <span class="text-gray-300">
                            (${message.time}):
                        </span>
                    </div>`
        },

        quote(message) {
            this.answer_content = '';
            if (window.getSelection().toString()) {

                const content = window.getSelection().toString();
                if (!message.content.includes(content)) return

                this.quote_content = `<div class="text-sm select-none">
                        <span class="text-gray-500 italic">
                            Quote message from
                        </span>
                        <span class="">
                            ${message.user.name}:
                        </span>
                        <span class="">
                            ${content}
                        </span>
                        <span class="text-gray-300">
                            (${message.time}):
                        </span>
                    </div>`
            }
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
