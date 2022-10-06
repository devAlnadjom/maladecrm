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

import JetDialogModal from '@/Jetstream//DialogModal.vue';

const props = defineProps({
    project: Object,
});
const openCreateListe= ref(false);

const form = useForm({
    _method: "PUT",
    name: props.project?.name,
    categorie: props.project?.categorie,
    address: props.project?.address,
    contact: props.project?.contact,
    description: props.project?.description,
    active: props.project?.active,
});

const formTask = useForm({
    task_name: '',
    task_description: '',
    task_theme: 'Indigo',
    task_estimated_price: 0,
    task_start_date:'',
    task_due_date: '',
    task_done: false,
});
console.log(props.project);
const submit = () => {
    form.post(route('project.update', props.project?.id), {
        //onFinish: () => form.reset(),
    });
};

const submitTask = () => {
    formTask.post(route('project.storetask'/*, props.project?.id*/), {
        //onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Gestion des Projets">

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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>

                            <span>{{ project?.project_category }} </span>
                        </div>
                        <div v-if="project?.project_estimated_price > 0" class="text-sm flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ project?.project_estimated_price / 100 }} XAF</span>
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
                    <Link v-if="props.project.tasks.length > 0" :href="route('payments.create') + '?project_id=' + props.project.id"
                        class="flex items-center mx-2 justify-between w-42 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Ajouter une Tache
                    <span class="ml-2" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </span>
                    </Link>
                    <button @click="openCreateListe = true"
                        class="flex items-center justify-between w-42 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        <span class="mr-2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                        </span>
                        Creer une Liste

                    </button>
                </div>

            </div>


            <div class="mt-5 bg-white">
                <AlertBox :flash="$page.props.flash" :on="true" class="mr-3">

                </AlertBox>
                <div class="w-full flex justify-between mx-auto py-5 sm:px-6 lg:px-8 gap-2">
                    <div class="flex-1">
                        <h3 class="text-bold"> Infos General</h3>
                        <p class="text-sm">Les informations general de votre entreprise, qui apparraissent sur vos
                            factures</p>
                    </div>

                </div>
                <!--Infos section-->
                <div class="w-full flex  justify-between mx-auto py-5 sm:px-6 lg:px-8 gap-2">
                    <div class="md:w-1/3 lg:1/4 p-6 bg-white-800 border rounded">
                        <div class="bg-indigo-400 hover:bg-indigo-500 h-20 rounded">
                        </div>
                        <div class="mt-4 text-sm md:flex ">
                            <div class="flex-1">
                                <h4 class="font-bold">Title</h4>
                                <span> Information</span>
                            </div>
                            <span @click="open_comment = !open_comment"
                            class="p-1 rounded text-indigo-500 hover:text-indigo-700 hover:bg-indigo-100 cursor-pointer" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </span>

                        </div>

                        <div class="mt-4 text-sm ">
                            <h4 class="font-bold text-gray-700">Description</h4>
                            <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                 Laudantium commodi ut, ea tenetur fuga consequatur fugit ipsum minus nam,
                                  a nisi non? Distinctio eligendi deleniti nulla, dolore a quasi explicabo.</p>
                        </div>

                        <div class="mt-4 text-sm ">
                            <h4 class=" text-gray-700">Client</h4>
                            <span class="font-bold">Olymprix Car SA.</span>
                        </div>

                        <div class="mt-4 text-sm ">
                            <h4 class=" text-gray-700">Date  ( Interval)</h4>
                            <div class="font-bold">
                                <span> XX/XX/XXXX</span> - <span> XX/XX/XXX</span>
                            </div>

                        </div>
                        <div class="mt-4 text-sm ">
                            <h4 class=" text-gray-700">Categories</h4>
                            <span class="font-bold"> {{ project?.project_category }} </span>
                        </div>
                    </div>
                    <div class="flex-1 p-6 rounded">
                        <div class="mt-4 w-full .text-sm md:flex ">
                            <h4 class="font-bold flex flex-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                </svg>

<span class="ml-2 inline-block">Liste et Taches (0)</span></h4>
                            <span @click="openCreateListe = true"
                            class="p-1 rounded text-indigo-500 hover:text-indigo-700 hover:bg-indigo-100 cursor-pointer" title="Nouvelle liste">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </span>

                        </div>
                        <div>
                            <div class="mt-4  md:flex gap-8">
                                <div class="md:w-4/5 p-2 bg-gray-200 animate-pulse rounded-lg"></div>
                                <div class="flex-1 p-2 bg-gray-200 animate-pulse rounded-lg"></div>
                            </div>
                            <div class="mt-4  md:flex gap-8">
                                <div class="md:w-4/5 p-2 bg-gray-200 animate-pulse rounded-lg"></div>
                                <div class="flex-1 p-2 bg-gray-200 animate-pulse rounded-lg"></div>
                            </div>
                            <div class="mt-4  md:flex gap-8">
                                <div class="md:w-4/5 p-2 bg-gray-200 animate-pulse rounded-lg"></div>
                                <div class="flex-1 p-2 bg-gray-200 animate-pulse rounded-lg"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            <!--Dialog of Messassage -->
            <JetDialogModal :show="openCreateListe" @close="openCreateListe = !openCreateListe">
                <template #title>

                    <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">
                        <span class=" inline-block flex-1 mr-2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </span><span class=" inline-block">Creer une nouvelle Liste</span>
                    </h2>
                </template>

                <template #content>

                    <div class="w-full rounded-lg bg-white overflow-hidden  block ">

                        <div class="mb-4">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Nom </label>
                            <JetInput  type="text" v-model="formTask.task_name" placeholder="Ex: Precision FactureX-001 "
                                class="mt-1 block w-full" />
                        </div>
                        <div class="mb-4">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Description</label>
                                 <textarea id="description" rows="3" type="text" v-model="formTask.task_description"
                                            placeholder="Contenu du message"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>

                        </div>

                        <div class="md:grid grid-cols-2 gap-2">
                        <div class="mb-2">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Date Debut </label>
                            <JetInput  type="date" v-model="formTask.task_start_date" placeholder="Ex: Precision FactureX-001 "
                                class="mt-1 block w-full" />
                        </div>
                        <div class="mb-2">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Date Fin </label>
                            <JetInput  type="date" v-model="formTask.task_due_date" placeholder="Ex: Precision FactureX-001 "
                                class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Prix </label>
                            <JetInput  type="number" v-model="formTask.task_estimated_price" placeholder="Ex: Precision FactureX-001 "
                                class="mt-1 block w-full" />
                        </div>
                        </div>

                    </div>
                </template>

                <template #footer>
                    <JetSecondaryButton @click="openCreateListe = !openCreateListe">
                        Fermer
                    </JetSecondaryButton>

                    <JetButton class="ml-3" @click="submitTask">
                        <span class="flex-1 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>

                        </span>
                        Envoyer
                    </JetButton>
                </template>
            </JetDialogModal>
        </div>
    </AppLayout>
</template>
