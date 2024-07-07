<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const currentRoute = page.url;
</script>

<template>
    <Head title="Forum"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="" v-if="currentRoute === '/profile/avatar'">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
            </div>
            <div class="" v-else>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Forum</h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="w-2/6 mx-auto my-6 border">
                        <h3 class="text-xl font-bold text-center">Menu</h3>
                        <div class="">
                            <Link :href="route('admin.index')" >
                                Statistics
                            </Link>
                        </div>
                        <div class="">
                            <Link :href="route('admin.complaints.index')" >
                                Complaints
                            </Link>
                        </div>
                        <div class="">
                            <Link :href="route('admin.roles.index')" >
                                Roles
                            </Link>
                        </div>
                    </div>

                    <div class="w-4/6 mx-auto my-6 border">

                        <slot/>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "AdminLayout",

    components: {
        Link
    }
}
</script>

<style scoped>

</style>
