<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class=""><h1>Create Theme</h1></div>

                    <div class="">
                        <div class="">
                            <input v-model="title" placeholder="Enter theme title" class="">
                            <div class="text-xs text-red-600" v-if="this.$page.props.errors.title">
                                {{ this.$page.props.errors.title }}
                            </div>
                            <div class="flex items-center">
                                <input v-model="description" placeholder="Enter theme description" class="">
                                <a @click.prevent="store()"
                                   class="bg-indigo-500 rounded-full py-1 px-3" href="#">
                                    Create
                                </a>
                            </div>
                            <div class="text-xs text-red-600" v-if="this.$page.props.errors.description">
                                {{ this.$page.props.errors.description }}
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
        'branch'
    ],

    data() {
        return {
            title: '',
            description: '',
        }
    },

    methods: {
        store() {
            this.$inertia.post('/themes', {title: this.title, branch_id: this.branch.id, description: this.description});
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
