<template>
    <div class="">
        <div class="text-center mx-2 text-xl font-bold">
            Complaints list
        </div>
        <div class="m-2">
            <table class="border border-separate border-slate-400 table w-full text-center">
                <thead>
                    <tr>
                        <th class="border-slate-400 border">ID</th>
                        <th class="border-slate-400 border">Body</th>
                        <th class="border-slate-400 border">User</th>
                        <th class="border-slate-400 border">Message</th>
                        <th class="border-slate-400 border">Solved?</th>
                        <th class="border-slate-400 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="complaint in complaints">
                        <td class="border-slate-400 border">{{ complaint.id }}</td>
                        <td class="border-slate-400 border">{{ complaint.body }}</td>
                        <td class="border-slate-400 border">{{ complaint.user.name }}</td>
                        <td class="border-slate-400 border text-indigo-700 animate-pulse">
                            <Link :href="route('themes.show', complaint.theme_id) + '?page=' + complaint.page + `#${complaint.message_id}`">Link</Link>
                        </td>
                        <td class="border-slate-400 border">{{ complaint.is_solved ? 'Solved' : 'In work' }}</td>
                        <td class="border-slate-400 border">
                            <a href="" @click.prevent="update(complaint)" class="block mx-auto w-6 h-6">
                                <svg xmlns="http://www.w3.org/2000/svg" :fill="complaint.is_solved ? 'green' : 'red'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </a>
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
        'complaints',
    ],

    methods: {
        update(complaint) {
            axios.patch(`/admin/complaints/${complaint.id}`)
                .then(res => {
                    complaint.is_solved = res.data.is_solved
                });
        },
    },

    layout: AdminLayout
}
</script>

<style scoped>

</style>
