<template>
    <div class="">
        <div class="text-center mx-2 text-xl font-bold">
            User list
        </div>
        <div class="m-2">
            <table class="border border-separate border-slate-400 table w-full text-center">
                <thead>
                <tr>
                    <th class="border border-slate-400">ID</th>
                    <th class="border border-slate-400">Name</th>
                    <th class="border border-slate-400">Role code</th>
                    <th class="border border-slate-400">Add/Remove Role</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td class="border border-slate-400">{{ user.id }}</td>
                        <td class="border border-slate-400">{{ user.name }}</td>
                        <td class="border border-slate-400">
                            <p v-for="role in user.roles">
                                {{ role.code }}
                            </p>
                        </td>
                        <td class="border border-slate-400 relative">
                            <div>
                                <a href="" @click.prevent="selectRolesToggle(user)">
                                    <div class="text-pink-600">{{ !user.select_roles ? 'Choose role' : 'Close' }}</div>
                                </a>
                                <div class="static z-50 bg-white">
                                    <div class="px-1 text-left mx-4" v-for="role in roles" :hidden="!user.select_roles">
                                        <input type="checkbox" class="mr-1" @change="roleToggle(user, role.id)"
                                               :id="role.id" :value="role.id" :checked="roleIds(user.roles).includes(role.id)">
                                        <label :for="role.id" class="italic">{{ role.code }}</label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";

export default {
    name: "Index",

    components: {
        Link
    },

    props: [
        'users',
        'roles'
    ],

    methods: {
        roleIds(roles) {
            return roles.map(role => role.id);
        },

        roleToggle(user, roleId) {
            axios.post(`/admin/users/${user.id}/role`, {
                role_id: roleId
            })
                .then(res => {
                    user.roles = res.data.roles
                });
        },

        selectRolesToggle(user) {
            user.select_roles = !user.select_roles

            this.users.filter(filteredUser => {
                return filteredUser.id !== user.id
            }).map( user => user.select_roles = false);
        },
    },

    layout: AdminLayout
}
</script>

<style scoped>

</style>
