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
                        <div class="text-sm mx-3 mb-1 flex" v-for="message in messages">
                            <div class="italic mr-2">
                                {{ message.user.name}}
                            </div>
                            <div class="mr-2">
                                {{ message.content }}
                            </div>
                            <div class="">
                                {{ message.time }}
                            </div>
                        </div>
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
        'messages'
    ],

    mounted() {

    },


    data() {
        return {


        }
    },

    methods: {
        store() {
            axios.post('/fmessages', {
                theme_id: this.theme.id,
                content: this.$refs.message.innerHTML,
            })
                .then( res => {
                    this.$refs.message.innerHTML = ''
                });
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
