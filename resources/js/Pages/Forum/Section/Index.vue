<template>
    <div class="flex">
        <div class="">
            <div class="text-xl font-bold mb-3">
                <div class="flex items-center">
                    <Link :href="route('sections.create')" class="bg-indigo-300 rounded-lg ml-4 py-1 px-3">Add section</Link>
                    <Link :href="route('branches.create')" class="bg-emerald-200 rounded-lg ml-4 py-1 px-3">Add branch</Link>
                </div>
                <div class="">
                    <h1 class="mt-10">Section List...</h1>
                    <div class="" v-if="this.sections">
                        <div class="text-sm text-emerald-700 ml-3" v-for="section in this.sections">
                            <div class="flex items-center">
                                <div class="mr-3 my-2">
                                    {{ section.title }}
                                </div>
                                <a @click.prevent="edit(section.id)" href="#" class="mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                                <Link :href="route('sections.destroy', section.id)" class="mr-3" method="delete" as="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </Link>
                                <div class="" v-if="isEdit[section.id]">
                                    <input type="text" v-model="section_title" :id="section.id" :placeholder="section.title" class="text-xs">
                                    <a @click.prevent="saveSectionTitle(section.id, section_title)" href="" class="py-2 px-3 bg-emerald-300 rounded-lg ml-3">Save</a>
                                </div>
                            </div>

                            <div class="" v-if="section.branches">
                                <div class="flex items-center text-xs text-emerald-900 ml-6" v-for="branch in section.branches">
                                    <div class="mr-1">&#8627;</div>
                                    <Link :href="route('branches.show', branch.id)">
                                        <div class="">{{ branch.title }}</div>
                                    </Link>
                                    <Link :href="route('branches.edit', branch.id)" class="mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="pink" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 ml-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </Link>
                                    <Link :href="route('branches.destroy', branch.id)" class="mr-3" method="delete" as="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="pink" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </Link>
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
import {Link} from "@inertiajs/vue3";

export default {
    name: "Index",

    components: {
        Link
    },

    props: [
        'sections'
    ],

    data() {
        return {
            section_title: '',
            isEdit: {},

        }
    },

    /*created() {
        window.Echo.channel('users-channel.' + this.$page.props.auth.user.id)
            .listen('.store-message-status-broadcast-name', res => {
                this.chats.filter(chat => {
                    if (chat.id === res.chat_id) {
                        chat.unreadable_message_count = res.count
                        chat.last_message = res.message
                    }
                });
            });
    },*/

    methods: {
        edit(id) {
            this.section_title = ''
            this.isEdit[id] = !this.isEdit[id]
        },

        saveSectionTitle(id, title) {
            this.isEdit[id] = false
            this.$inertia.patch('/sections/' + id, {title: title});
        },

    },

    layout: Main
}
</script>

<style scoped>

</style>
