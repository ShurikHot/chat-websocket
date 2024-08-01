<template>
    <div class="flex items-center justify-center mx-2 text-xl font-bold">
        <h1>Edit Role </h1>
        <h1 class="text-red-600 ml-2"> {{ old_title }}</h1>
    </div>
    <div class="flex m-2">
        <div class="">
            <div class="text-xl font-bold mb-3">
                <div class="">
                    <div class="" v-if="sections.length > 0">
                        <select @change="getBranchesWhenChange()" class="mb-1 rounded-lg" v-model="section_id">
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
                        <select class="mb-1 rounded-lg" v-model="branch_id">
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
                            <select v-model="title" class="mb-1 rounded-lg">
                                <option disabled value="">Choose role title</option>
                                <option v-for="role in baseRoles">
                                    {{ role }}
                                </option>
                            </select>
                            <a @click.prevent="update(branch_id)"
                               :class="['bg-indigo-500 rounded-lg py-1 px-3 ml-2',
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
        'role_data',
        'baseRoles'
    ],

    data() {
        return {
            old_title: Object.values(this.role_data).slice(0, -1).join('.'),
            title: this.role_data[0],
            section_id: this.role_data[1],
            branch_id: this.role_data[2],
            branches: [],
        }
    },

    mounted() {
        if (this.section_id) this.getBranchesMount();
    },

    methods: {
        update(branchId) {
            if (this.title === 'Admin') {
                this.section_id = null
                this.branch_id = null
            }
            this.$inertia.patch('/admin/roles/' + this.role_data.id, {title: this.title, section_id: this.section_id, branch_id: this.branch_id});
        },

        getBranchesMount() {
            axios.get('/sections/' + this.section_id + '/branches')
                .then(res => {
                    this.branches = res.data
                })
            ;
        },

        getBranchesWhenChange() {
            this.getBranchesMount()
            this.branch_id = null
        },
    },

    layout: AdminLayout
}
</script>

<style scoped>

</style>
