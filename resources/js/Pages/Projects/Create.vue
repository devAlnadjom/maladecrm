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

import AlertBox from '@/Jetstream/AlertBox.vue';

const props = defineProps({
    customers: Object,
    customer_id: Object,
});


const form = useForm({
    project_name: '', //
    project_category: '',//
    project_description: '',
    project_status: '',
    project_theme: '',
    project_estimated_price: '',
    project_start_date: '',
    project_end_date: '',
    project_end_date: '',
    project_template_id: '',
    customer_id: null,
    active: 0,
});

const submit = () => {
    form.post(route('projects.store'), {
        onFinish: () => {},
    });
};
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-8 px-8">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('projects.index')">Vos Projets</Link> / Nouveau
                </h3>
            </div>

            <div class="mt-5">
                <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8">
                    <AlertBox :flash="$page.props.flash" :on="true" class="mr-3 mb-4"></AlertBox>

                    <div class="">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 rounded-md bg-white">
                            <form @submit.prevent="submit">
                                <div>
                                    <JetLabel for="name" value="Nom du Projet" />
                                    <JetInput id="name" v-model="form.project_name" type="text" class="mt-1 block w-full"
                                        required autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="Method" value="Categorie" />
                                        <select
                                            class="text-gray-700 mt-1 block appearance-none w-full bg-gray-200 border-2 border-gray-200 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                            v-model="form.project_category">
                                            <option value="">Select. une Methode</option>
                                            <option value="DEVELOPPENT WEB">DEVELOPPENT WEB</option>
                                            <option value="WEB DESIGN">WEB DESIGN</option>
                                            <option value="IT SUPPORT">IT SUPPORT</option>
                                            <option value="Autres">Autres</option>
                                        </select>
                                    </div>

                                    <div class="w-full">
                                        <JetLabel for="Prixestime" value="Prix estime" />
                                        <JetInput id="Prixestime" v-model="form.project_estimated_price" type="number"
                                            class="mt-1 block w-full"  required/>
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="description" value="Description" />
                                        <textarea id="description" rows="3" v-model="form.project_description" type="text"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                            <JetLabel for="date" value="Date de Debut" />
                                            <JetInput id="date" v-model="form.project_start_date" type="date"
                                                class="mt-1 block w-full" />
                                        </div>

                                        <div class="w-full">
                                            <JetLabel for="date" value="Date de Butoire" />
                                            <JetInput id="date" v-model="form.project_end_date" type="date"
                                                class="mt-1 block w-full" />
                                        </div>
                                </div>
                                <div class="mt-6 .flex flex-row gap-4 w-full">
                                    <JetLabel for="description" value="Selectionner un theme" />
                                    <ul class="mt-2 grid gap-6 w-full md:grid-cols-4">
                                        <li>
                                            <input type="radio" id="hosting-small" v-model="form.project_theme" name="hosting" value="BLUE" class="hidden peer" required>
                                            <label for="hosting-small" class="inline-flex justify-between items-center p-2 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                <div class="block">
                                                    <div class="w-full font-semibold">BLUE</div>
                                                </div>
                                                <svg aria-hidden="true" class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="hosting-big" v-model="form.project_theme" name="hosting" value="RED" class="hidden peer">
                                            <label for="hosting-big" class="inline-flex justify-between items-center p-2 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-red-600 peer-checked:text-red-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                <div class="block">
                                                    <div class="w-full font-semibold">RED</div>
                                                </div>
                                                <svg aria-hidden="true" class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="green-color" v-model="form.project_theme" name="hosting" value="GREEN" class="hidden peer">
                                            <label for="green-color" class="inline-flex justify-between items-center p-2 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-green-600 peer-checked:text-green-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                <div class="block">
                                                    <div class="w-full font-semibold">RED</div>
                                                </div>
                                                <svg aria-hidden="true" class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </label>
                                        </li>
                                        <li>
                                            <input type="radio" id="yellow-color" v-model="form.project_theme" name="hosting" value="YELLOW" class="hidden peer">
                                            <label for="yellow-color" class="inline-flex justify-between items-center p-2 w-full text-gray-500 bg-white rounded-lg border border-gray-200 cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-yellow-600 peer-checked:text-yellow-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                <div class="block">
                                                    <div class="w-full  font-semibold">YELLOW</div>
                                                </div>
                                                <svg aria-hidden="true" class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </label>
                                        </li>
                                    </ul>
                                </div>





                                <div class="mt-4">
                                    <div class="flex w-1/2 gap-6">
                                        <JetLabel for="active">
                                            <div class="flex items-center">
                                                <JetCheckbox id="active" v-model:checked="form.active" name="active" />

                                                <div class="ml-2">
                                                    Selectionner un client
                                                </div>
                                            </div>
                                        </JetLabel>

                                        <select v-if="form.active==1" class="mt-1 block w-full bg-gray-100 border-0 rounded"
                                                v-model="form.customer_id" @change="selectedCustomer()">
                                                <option :value="null"> Selectioner un Client</option>
                                                <template v-for="(item, index) in customers" :key="index">
                                                    <option :value="item.id"> {{ item.name }}
                                                    </option>
                                                </template>
                                        </select>
                                    </div>


                                </div>

                                <div class="flex items-center justify-end mt-4">


                                    <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Enregistrer
                                    </JetButton>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
