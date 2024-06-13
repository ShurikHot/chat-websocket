<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class=""><h1>Single Branch</h1></div>
                    <div class="" v-if="branch">
                        <div class="text-red-600">
                            {{ branch.title }}
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
    name: "Show",

    components: {
        Link
    },

    props: [
        'branch'
    ],

    data() {
        return {

        }
    },

    methods: {

    },

    layout: Main
}
</script>

<style scoped>

</style>
