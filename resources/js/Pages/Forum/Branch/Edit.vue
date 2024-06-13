<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class=""><h1>Edit Branch</h1></div>
                    <div class="" v-if="sections.length > 0">
                        <select @change="getBranches()" class="" v-model="section_id">
                            <option value="null" disabled>Choose the section</option>
                            <option v-for="section in sections" :value="section.id">{{section.title}}</option>
                        </select>
                    </div>
                    <div class="text-xs text-red-600" v-if="this.$page.props.errors.section_id">
                        {{ this.$page.props.errors.section_id }}
                    </div>

                    <div class="" v-if="branches.length > 0">
                        <select class="" v-model="parent_id">
                            <option value="null" disabled>Choose the parent branch</option>
                            <option v-for="branch in branches" :value="branch.id" :disabled="this.branch.id === branch.id">
                                {{branch.title}}
                            </option>
                        </select>
                    </div>
                    <div class="text-xs text-red-600" v-if="this.$page.props.errors.parent_id">
                        {{ this.$page.props.errors.parent_id }}
                    </div>

                    <div class="">
                        <div class="flex items-center">
                            <input v-model="title" placeholder="Enter branch title" class="">
                            <a @click.prevent="update()"
                               :class="['bg-indigo-500 rounded-full py-1 px-3',
                               section_id == null ? 'opacity-50 cursor-not-allowed' : ''
                            ]" href="#"
                               :disabled="section_id == null">
                                Save
                            </a>
                        </div>
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
</template>

<script>
import Main from "@/Layouts/MainForum.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Edit",

    components: {
        Link
    },

    props: [
        'sections',
        'branch'
    ],

    data() {
        return {
            title: this.branch.title,
            section_id: this.branch.section_id,
            parent_id: null,
            branches: [],

        }
    },

    mounted() {
        this.getBranches();
        this.parent_id = this.branch.parent_id
    },

    methods: {
        update() {
            this.$inertia.patch('/branches/' + this.branch.id, {title: this.title, section_id: this.section_id, parent_id: this.parent_id});
        },

        getBranches() {
            this.parent_id = null
            axios.get('/sections/' + this.section_id + '/branches')
                .then(res => {
                    this.branches = res.data
                })
            ;
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
