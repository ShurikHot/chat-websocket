<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class=""><h1>Create Section</h1></div>
                    <div class="">
                        <div class="flex items-center">
                            <input v-model="title" placeholder="Enter section title" class="mx-2">
                            <a @click.prevent="store()" class="bg-indigo-500 rounded-full py-1 px-3" href="#">Create</a>
                        </div>
                        <div class="">
                            <div class="text-xs text-red-600" v-if="this.$page.props.errors.title">
                                {{ this.$page.props.errors.title }}
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
    name: "Create",

    components: {
        Link
    },

    props: [

    ],

    data() {
        return {
            title: ''
        }
    },

    methods: {
        store() {
            this.$inertia.post('/sections', {title: this.title})
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
