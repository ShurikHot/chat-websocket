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
            <div class="">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Forum</h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="w-5/6 mx-auto my-6">

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
    name: "MainForum",

    components: {
        Link
    }
}
</script>

<style scoped>

</style>
