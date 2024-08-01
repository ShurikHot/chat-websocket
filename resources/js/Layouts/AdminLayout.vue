<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const currentRoute = computed(() => page.url);
</script>

<template>
    <Head title="Forum"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Panel</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="w-2/6 mx-6 my-6 border">
                        <h3 class="text-xl font-bold text-center">Menu</h3>
                        <div :class="['ml-4 mt-2 text-lg',
                        currentRoute === '/admin' ? 'animate-pulse text-sky-600' : ''
                        ]">
                            <Link :href="route('admin.index')" >
                                Statistics
                            </Link>
                        </div>
                        <div :class="['ml-4 mt-2 text-lg',
                        currentRoute.includes('/admin/complaints') ? 'animate-pulse text-sky-600' : ''
                        ]">
                            <Link :href="route('admin.complaints.index')" >
                                Complaints
                            </Link>
                        </div>
                        <div :class="['ml-4 mt-2 text-lg',
                        currentRoute.includes('/admin/roles') ? 'animate-pulse text-sky-600' : ''
                        ]">
                            <Link :href="route('admin.roles.index')" >
                                Roles
                            </Link>
                        </div>
                        <div :class="['ml-4 mt-2 text-lg',
                        currentRoute.includes('/admin/users') ? 'animate-pulse text-sky-600' : ''
                        ]">
                            <Link :href="route('admin.users.index')" >
                                Users
                            </Link>
                        </div>
                    </div>

                    <div class="w-4/6 mr-6 my-6 border">

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
