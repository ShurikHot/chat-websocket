<template>
    <div class="text-center mx-2 text-xl font-bold">
        <h1>Create Role</h1>
    </div>
    <div class="flex m-2">
        <div class="text-xl font-bold mb-3">
            <div class="">
                <div class="" v-if="sections.length > 0">
                    <select @change="getBranches()" class="mb-1 rounded-lg" v-model="section_id">
                        <option value="null" selected disabled>Choose the section</option>
                        <option v-for="section in sections" :value="section.id">{{section.title}}</option>
                    </select>
                </div>
                <div class="text-xs text-red-600" v-if="this.$page.props.errors.section_id">
                    {{ this.$page.props.errors.section_id }}
                </div>

                <div class="" v-if="branches.length > 0">
                    <select class="mb-1 rounded-lg" v-model="branch_id">
                        <option value="null" selected disabled>Choose the branch</option>
                        <option v-for="branch in branches" :value="branch.id">{{branch.title}}</option>
                    </select>
                </div>
                <div class="text-xs text-red-600" v-if="this.$page.props.errors.parent_id">
                    {{ this.$page.props.errors.parent_id }}
                </div>

                <div class="flex items-center">
                    <select v-model="title" class="mb-1 rounded-lg">
                        <option disabled value="">Choose role title</option>
                        <option v-for="role in baseRoles">
                            {{ role }}
                        </option>
                    </select>
                    <a @click.prevent="store()"
                       :class="['bg-indigo-500 rounded-lg py-1 px-3 ml-2',
                       title === '' ? 'opacity-50 cursor-not-allowed' : ''
                    ]" href="#"
                       :disabled="title === ''">
                        Create
                    </a>
                </div>
                <div class="">
                    <div class="text-xs text-red-600" v-if="this.$page.props.errors.title">
                        {{ this.$page.props.errors.title }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";

export default {
    name: "Create",

    components: {
        Link
    },

    props: [
        'sections',
        'baseRoles'
    ],

    data() {
        return {
            title: '',
            section_id: null,
            branch_id: null,
            branches: [],
        }
    },

    methods: {
        store() {
            if (this.title === 'Admin') {
                this.section_id = null
                this.branch_id = null
            }
            this.$inertia.post(route('admin.roles.store'), {
                title: this.title,
                section_id: this.section_id,
                branch_id: this.branch_id,
            })
        },

        getBranches() {
            this.branch_id = null
            axios.get('/sections/' + this.section_id + '/branches')
                .then(res => {
                    this.branches = res.data
                })
            ;
        },
    },

    layout: AdminLayout
}
</script>

<style scoped>

</style>
