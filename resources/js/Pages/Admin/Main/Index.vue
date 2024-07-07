<template>
    <div class="flex">
        <div class="" v-if="statistics">
            <div class="flex" v-for="statistic in statistics">
                <span v-html="statistic.icon"></span> {{ statistic.title }} : {{ statistic.count }}
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Index",

    components: {
        Link
    },

    props: [
        'statistics'
    ],

    /*mounted() {
        console.log(this.statistics);
    },*/

    data() {
        return {

        }
    },

    methods: {


    },

    layout: AdminLayout
}
</script>

<style scoped>

</style>
