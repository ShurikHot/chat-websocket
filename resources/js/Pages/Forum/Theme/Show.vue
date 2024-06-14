<template>
    <div class="flex">
        <div class="w-3/4">
            <div class="text-center text-xl font-bold mb-3">
                <div class="text-left">
                    <div class=""><h1>Single Theme</h1></div>
                    <div class="" v-if="theme">
                        <div class="text-red-600">{{ theme.title }}</div>
                        <div class="text-xs ml-2 -mt-2 text-gray-500">
                            {{ theme.description }}
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

export default {
    name: "Show",

    components: {
        Link
    },

    props: [
        'theme'
    ],

    mounted() {

    },


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
