<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class=""><h1>Create Branch</h1></div>
                    <div class="" v-if="sections.length > 0">
                        <select @change="getBranches()" class="mb-1 rounded-lg" v-model="section_id">
                            <option value="null" selected disabled>Choose the section</option>
                            <template v-for="section in sections">
                                <template v-if="isSectionRole(section.id)">
                                    <option :value="section.id">
                                        {{section.title}}
                                    </option>
                                </template>
                            </template>
                        </select>
                    </div>
                    <div class="text-xs text-red-600" v-if="this.$page.props.errors.section_id">
                        {{ this.$page.props.errors.section_id }}
                    </div>

                    <div class="" v-if="branches.length > 0">
                        <select class="mb-1 rounded-lg" v-model="parent_id">
                            <option value="null" selected disabled>Choose the branch</option>
                            <template v-for="branch in branches">
                                <template v-if="isSectionBranchRole(section_id, branch.id)">
                                    <option :value="branch.id">
                                        {{branch.title}}
                                    </option>
                                </template>
                            </template>
                        </select>
                    </div>
                    <div class="text-xs text-red-600" v-if="this.$page.props.errors.parent_id">
                        {{ this.$page.props.errors.parent_id }}
                    </div>

                    <div class="">
                        <div class="flex items-center">
                            <input v-model="title" placeholder="Enter branch title" class="rounded-lg w-1/2">
                            <a @click.prevent="store()"
                               :class="['bg-indigo-500 rounded-lg py-1 px-3 ml-2',
                               section_id == null || title === '' ? 'opacity-50 cursor-not-allowed' : ''
                            ]" href="#"
                               :disabled="section_id == null">
                                Create
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
    name: "Create",

    components: {
        Link
    },

    props: [
        'sections'
    ],

    data() {
        return {
            title: '',
            section_id: null,
            parent_id: null,
            branches: [],
        }
    },

    methods: {
        store() {
            this.$inertia.post('/branches', {title: this.title, section_id: this.section_id, parent_id: this.parent_id});
        },

        getBranches() {
            this.parent_id = null
            axios.get('/sections/' + this.section_id + '/branches')
                .then(res => {
                    this.branches = res.data
                })            ;
        },

        isSectionRole(section_id) {
            return this.$page.props.auth.roles.some( code => {
                return [
                    'Admin',
                    `Editor.${section_id}`,
                ].includes(code);
            })
        },

        isSectionBranchRole(section_id, branch_id) {
            return this.$page.props.auth.roles.some( code => {
                return [
                    'Admin',
                    `Editor.${section_id}`,
                    `Editor.${section_id}.${branch_id}`,
                ].includes(code);
            })
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
