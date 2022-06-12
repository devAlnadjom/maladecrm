<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';



const props = defineProps({
    company: Object,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hello
            </h2>
        </template>

        <div class="py-12">
            <div class="max -w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="company==null" class=" bg-red-500 rounded-md border px-10 py-4 my-5 w-full">
                    <h3 class=" text-white"> You have to set your company setting</h3>
                    <Link :href="route('companies.create')">
                        <div class="mt-1 flex items-center text-sm font-semibold text-gray-100 hover:text-white">
                            <div>Set Up my Company</div>

                            <div class="ml-1 ">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </Link>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
