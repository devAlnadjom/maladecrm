<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';

const props = defineProps({
    project: Object,
});


const form = useForm({
    _method: "PUT",
    name: props.project?.name,
    categorie: props.project?.categorie,
    address: props.project?.address,
    contact: props.project?.contact,
    description: props.project?.description,
    active: props.project?.active,
});
console.log(props.project)
const submit = () => {
    form.post(route('project.update', props.project?.id), {
        //onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Customer Management">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <div>

                    <div class="text-sm text-gray-500">
                        Acceuil /
                        <Link class="text-gray-600 hover:text-gray-800" :href="route('projects.index')">Projets</Link>
                    </div>
                    <div class="flex">
                        <h3 class=" mt-3 font-extrabold text-2xl text-gray-900">
                            {{ project?.project_name }}
                        </h3>

                    </div>

                    <div class="grid grid-cols-2 gap-4 md:flex md:gap-4 mt-3 text-gray-500 font-semibold">
                        <div class="text-sm flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ project?.project_category }} </span>
                        </div>
                        <div class="text-sm flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ project?.project_estimated_price / 100 }} XAF</span>
                        </div>
                        <div class="text-sm flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ project?.project_theme }} </span>
                        </div>
                        <div v-if="project?.project_status" class="text-sm flex gap-1 text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <span>Actif {{project.project_status}}</span>
                        </div>

                    </div>
                </div>

                <div class="flex flex-row justify-end max-h-10">
                    <Link :href="route('payments.create') + '?project_id=' + props.project.id"
                        class="flex items-center mx-2 justify-between w-42 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Ajouter une Tache
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                    <Link :href="route('orders.create') + '?customer_id=' + props.project.id"
                        class="flex items-center justify-between w-42 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Creer une Liste
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <AlertBox :flash="$page.props.flash" :on="true" class="mr-3">

                </AlertBox>
                <div class="w-full flex justify-between mx-auto py-5 sm:px-6 lg:px-8 gap-2">
                    <div class="flex-1">
                        <h3 class="text-bold"> Infos General</h3>
                        <p class="text-sm">Les informations general de votre entreprise, qui apparraissent sur vos
                            factures</p>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
