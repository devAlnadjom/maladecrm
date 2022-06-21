<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '../../Jetstream/Pagination.vue';
const props= defineProps({
    feedbacks: Object,
    feedback: Object,
});

const formatMoney = (number) => {
    return 'XAF ' + number.toLocaleString('en-US');
};
/*const logout = () => {
    Inertia.post(route('logout'));
};*/
</script>

<template>
    <AppLayout title="List of feeback">


        <div class="py-8">
            <div class=" px-3 flex flex-row justify-between">
                <h3 class="text-xl">Feedback Management</h3>


            </div>
            <div class="mt-5 flex flex-row gap-3">
                <div class=" w-1/3">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg md:min-h-fit ml-3">

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Lis of Feedback
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="feedback in feedbacks.data" :key="feedback.id"
                                    class="bg-white dark:bg-gray-800 hover:bg-gray-100 border-t">
                                    <td scope="row"
                                        class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        <h4 class=" text-bold text-lg">{{ feedback?.type }}</h4>
                                        <p>From : {{ feedback?.user?.name }}</p>

                                            <Link class="text-green-400 hover:text-green-600 transition-colors" :href="route('feedbacks.index') + '?view=' + feedback.id" preserve-scroll>
                                            Infos</Link>

                                    </td>

                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-3 flex flex-row-reverse ">
                        <Pagination :links="feedbacks.links" />
                    </div>
                </div>

                <div class=" w-3/5 mr-3 border-dashed border-2 bg-gray-100 rounded" v-if="!feedback">
                    <div class="px-10 h-10">
                        Select On element
                    </div>
                </div>
                <div class=" w-1/2  mr-3 border bg-white rounded-lg max-h-min shadow" v-if="feedback">
                    <div class=" py-3 ">
                        <div class="flex justify-between">
                             <span class="mb-3 px-2 font-bold">{{feedback.type}}</span>
                             <span class="mb-3 px-2 ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                 {{feedback.created_at}}
                                </span>
                        </div>

                        <hr class="mt-1"/>
                        <p class="mt-3 px-2 ">{{feedback.comment}}</p>
                        <hr class="mt-3"/>
                        <span class=" px-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{feedback?.user?.name}} | {{feedback?.user?.email}}</span>

                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
