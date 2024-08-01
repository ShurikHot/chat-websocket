<template>
    <div class="flex">
        <div class="w-full">
            <div class="text-center text-xl font-bold mb-3">
                <template v-if="isSectionBranchRole(branch.section_id, branch.id)">
                    <div class="border p-3 rounded-full">
                        <div class="flex items-center justify-center">
                            <Link :href="route('themes.branchId.create', branch.id)"
                                  class="bg-emerald-200 rounded-lg mr-4 py-1 px-3 flex items-center">
                                <div class="">
                                    Add theme to the branch
                                </div>
                                <div class="text-red-600 ml-3">{{ branch.title }}</div>
                            </Link>
                        </div>
                    </div>
                </template>
                <div class="text-left">
                    <h1 class="mt-10 mb-2">Branch Map</h1>
                    <div class="ml-3" v-if="branch">
                        <div class="text-red-600 flex items-center border p-3 my-1 rounded-lg justify-between">
                            {{ branch.title }}
                        </div>

                        <div class="" v-if="this.children.length > 0">
                            <div class="flex items-center text-xs text-emerald-900 ml-6 mb-1 border p-1 rounded-lg justify-between"
                                 v-for="child in this.children">
                                <div class="flex items-center">
                                    <div class="mr-1 text-lg">&#8627;</div>
                                    <Link :href="route('branches.show', child.id)">
                                        <div class="">{{ child.title }}</div>
                                    </Link>
                                </div>

                                <div v-if="isSectionBranchParentRole(branch.section_id, branch.id, branch.parent_id)" class="flex items-center mr-1">
                                    <Link :href="route('branches.edit', child.id)" class="mr-3 border p-3 rounded-lg bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="pink" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                        </svg>
                                    </Link>
                                    <Link :href="route('branches.destroy', child.id)" class="mr-3 border p-3 rounded-lg bg-gray-200" method="delete"
                                          as="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="pink" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="" v-if="themes.length > 0">
                        <h1 class="mt-5 mb-2">Branch's Themes</h1>
                        <div class="flex items-center text-sm text-emerald-900 ml-3 mb-1 border p-1 rounded-lg justify-between" v-for="theme in themes">
                            <div class="flex items-center">
                                <div class="mr-1 text-lg">&#8627;</div>
                                <Link :href="route('themes.show', theme.id)">
                                    <div class="">{{ theme.title }}</div>
                                    <div class="text-xs ml-2 -mt-2 text-gray-500">
                                        {{ theme.description }}
                                    </div>
                                </Link>
                            </div>
                            <div v-if="isSectionBranchParentRole(branch.section_id, branch.id, branch.parent_id)" class="flex items-center">
                                <Link :href="route('themes.edit', theme.id)" class="mr-3 border p-3 rounded-lg bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="yellow" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                    </svg>
                                </Link>
                                <Link :href="route('themes.destroy', theme.id)" class="mr-3 border p-3 rounded-lg bg-gray-200" method="delete"
                                      as="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="yellow" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </Link>
                            </div>
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
        'branch',
        'children',
        'themes'
    ],

    methods: {
        isSectionBranchRole(section_id, branch_id) {
            return this.$page.props.auth.roles.some( code => {
                return [
                    'Admin',
                    `Editor.${section_id}`,
                    `Editor.${section_id}.${branch_id}`,
                ].includes(code);
            })
        },

        isSectionBranchParentRole(section_id, branch_id, parent_id) {
            return this.$page.props.auth.roles.some( code => {
                return [
                    'Admin',
                    `Editor.${section_id}`,
                    `Editor.${section_id}.${branch_id}`,
                    `Editor.${section_id}.${parent_id}`,
                ].includes(code);
            })
        },
    },

    layout: Main
}
</script>

<style scoped>

</style>
