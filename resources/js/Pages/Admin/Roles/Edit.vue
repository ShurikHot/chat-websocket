<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class="flex items-center">
                        <h1>Edit Role </h1>
                        <h1 class="text-red-600 ml-2"> {{ old_title }}</h1>
                    </div>
                    <div class="" v-if="sections.length > 0">
                        <select @change="getBranches()" class="" v-model="section_id">
                            <option value="null" disabled>Choose the section</option>
                            <option v-for="section in sections" :value="section.id" :selected="this.section_id === section.id">
                                {{section.title}}
                            </option>
                        </select>
                    </div>
                    <div class="text-xs text-red-600" v-if="this.$page.props.errors.section_id">
                        {{ this.$page.props.errors.section_id }}
                    </div>

                    <div class="" v-if="branches.length > 0">
                        <select class="" v-model="branch_id">
                            <option value="null" disabled>Choose the branch</option>
                            <option v-for="branch in branches" :value="branch.id" :selected="branch_id === branch.id">
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
                            <a @click.prevent="update(branch_id)"
                               :class="['bg-indigo-500 rounded-full py-1 px-3',
                               title === '' ? 'opacity-50 cursor-not-allowed' : ''
                            ]" href="#"
                               :disabled="title === ''">
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
import {Link} from "@inertiajs/vue3";
import axios from "axios";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Edit",

    components: {
        Link
    },

    props: [
        'sections',
        'role_data'
    ],

    data() {
        return {
            old_title: this.role_data[0],
            title: this.role_data[0],
            section_id: this.role_data[1],
            branch_id: this.role_data[2],
            branches: [],
        }
    },

    mounted() {
        this.getBranches();
        // console.log(this.branch_id);
        // console.log(this.role_data.id);
        /*this.parent_id = this.branch.parent_id*/
    },

    methods: {
        update(branchId) {
            console.log(branchId);
            this.$inertia.patch('/admin/roles/' + this.role_data.id, {title: this.title, section_id: this.section_id, branch_id: this.branch_id});
        },

        getBranches() {
            axios.get('/sections/' + this.section_id + '/branches')
                .then(res => {
                    this.branches = res.data
                    /*if (res.data.length === 0) this.branch_id = null*/
                })
            ;
        },
    },

    layout: AdminLayout
}
</script>

<style scoped>

</style>
