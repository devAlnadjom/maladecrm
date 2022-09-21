<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '../../Jetstream/Pagination.vue';
import ProjectCard from '../../Components/ProjectCard.vue';
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

                <div class="mt-6 grid md:grid-cols-3 lg:grid-cols-3 gap-4">
                    <template v-for="project in projects.data" :key="project.id">
                        <Link :href="route('projects.show', project.id)">
                            <ProjectCard :project="project"></ProjectCard>
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
