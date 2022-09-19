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

                    <!--table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                    </table-->


                </div>

                <div class="mt-6 grid md:grid-cols-3 lg:grid-cols-3 gap-4">
                    <template v-for="project in projects.data" :key="project.id">
                        <Link :href="route('projects.show', project.id)">
                        <div class="p-6 max-w-sm bg-white rounded-lg border-b-4 hover:bg-white transition-all duration-700 hover:scale-[1.03] border-gray-400 shadow-md dark:bg-gray-800 dark:border-gray-700">

                            <div class=" flex justify-between">
                                <span class="p-1 rounded bg-red-200 text-red-600 text-sm">Color</span>
                                <span class="p-1 rounded bg-gray-200 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>

                                </span>
                            </div>
                            <h3 class="my-4 font-bold text-lg"> {{ project?.project_name }} </h3>
                            <div class="flex .justify-between text-gray-600 pb-2 ">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                    </svg>
                                </span>
                                <span class="text-sm mx-2"> {{ project?.project_end_date }} </span>

                                <span class="ml-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>

                                </span>
                                <span class="ml-2 text-sm">{{ project?.tasks_count}} Tasks</span>
                            </div>
                            <p class="mb-3 font-normal text-sm text-gray-500  dark:text-gray-400">{{ project?.project_category}}</p>
                            <div  v-if="project?.client_name" class="flex  text-gray-600">
                                <span class="p-1 bg-gray-200 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                </span>
                                <span  class="text-sm mx-2 p-1"> Client Name</span>
                            </div>
                        </div>
                    </Link>
                    </template>



                </div>

                <div class="mt-3 flex flex-row-reverse ">
                    <Pagination :links="projects.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
