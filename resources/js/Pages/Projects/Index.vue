<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '../../Jetstream/Pagination.vue';
defineProps({
    projects: Object,
});


/*const logout = () => {
    Inertia.post(route('logout'));
};*/
</script>

<template>
    <AppLayout title="Projets">


        <div class="py-8 px-10">
            <div class="flex flex-row justify-between">
                <h3 class="text-xl">Gestions des Projets</h3>
                <div class="flex flex-row justify-end">
                    <Link :href="route('projects.create')"
                        class="flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Add Task
                        <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                    <Link :href="route('projects.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Create project
                        <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Company
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Contact
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Adresse
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Solde
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="project in projects.data" :key="project.id" class="bg-white dark:bg-gray-800 hover:bg-gray-100">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ project?.project_name }} = {{ project?.tasks_count }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ project?.project_theme }}-{{ project?.project_end_date }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ project?.project_theme }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ project?.project_category}}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <Link :href="route('projects.show', project.id)"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</Link>
                                    <Link :href="route('projects.show', project.id)"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Invoice</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>




                </div>

                <div class="mt-6 grid md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div class="p-6 max-w-sm bg-gray-700 rounded-lg border hover:bg-gray-900 transition-all duration-700 hover:scale-[1.05] border-gray-800 shadow-md dark:bg-gray-800 dark:border-gray-700">

                            <a href="#">
                                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-100  dark:text-white">Need a help in Claim?</h5>
                            </a>
                            <div class="flex justify-between text-white pb-1 border-b borrder-white">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                    </svg>
                                </span>
                                <span class="text-sm">2022-02-20</span>
                            </div>
                            <div class="flex justify-between text-white pt-2 pb-1 border-b borrder-white">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                    </svg>

                                </span>
                                <span class="text-sm">10 Tasks</span>
                            </div>
                            <p class="mb-3 font-normal text-sm text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                            <a href="#" class="inline-flex items-center text-blue-100 hover:underline">
                                See our guideline
                                <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
                            </a>
                        </div>
                        <div class="p-6 max-w-sm bg-blue-700 rounded-lg border border-blue-800 shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-100  dark:text-white">Need a help in Claim?</h5>
                            </a>
                            <p class="mb-3 font-normal text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                            <a href="#" class="inline-flex items-center text-blue-100 hover:underline">
                                See our guideline
                                <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
                            </a>
                        </div>
                        <div class="p-6 max-w-sm bg-violet-700 rounded-lg border border-violet-800 shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-100  dark:text-white">Need a help in Claim?</h5>
                            </a>
                            <p class="mb-3 font-normal text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                            <a href="#" class="inline-flex items-center text-blue-100 hover:underline">
                                See our guideline
                                <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
                            </a>
                        </div>
                        <div class="p-6 max-w-sm bg-green-700 rounded-lg border border-green-800 shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-100  dark:text-white">Need a help in Claim?</h5>
                            </a>
                            <p class="mb-3 font-normal text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                            <a href="#" class="inline-flex items-center text-blue-100 hover:underline">
                                See our guideline
                                <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
                            </a>
                        </div>
                </div>

                <div class="mt-3 flex flex-row-reverse ">
                    <Pagination :links="projects.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
