<template>
    <div class="flex">
        <div class="w-full">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class="flex items-center">
                        <h1>Edit Theme </h1>
                        <h1 class="text-red-600 ml-2"> {{ this.theme.title }}</h1>
                    </div>

                    <div class="">
                        <div class="">
                            <input v-model="title" placeholder="Enter theme title" class="mb-1 rounded-lg w-1/2">
                            <div class="text-xs text-red-600" v-if="this.$page.props.errors.title">
                                {{ this.$page.props.errors.title }}
                            </div>
                            <div class="flex items-center">
                                <input v-model="description" placeholder="Enter theme description" class="mb-1 rounded-lg w-1/2">
                                <a @click.prevent="store()"
                                   :class="['bg-indigo-500 rounded-lg py-1 px-3 ml-2',
                                    title === '' || description === '' ? 'opacity-50 cursor-not-allowed' : ''
                                    ]" href="#"
                                   :disabled="title === ''">
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
    name: "Edit",

    components: {
        Link
    },

    props: [
        'theme'
    ],

    data() {
        return {
            title: this.theme.title,
            description: this.theme.description,
        }
    },

    methods: {
        update() {
            this.$inertia.patch('/themes/' + this.theme.id, {title: this.title, branch_id: this.theme.branch_id, description: this.description});
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
