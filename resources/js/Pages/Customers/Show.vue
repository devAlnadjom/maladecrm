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
import EditForm from './Partials/EditForm.vue';
import Invoices from './Partials/Invoices.vue';

const props = defineProps({
    customers: Object,
});

const tabs_position = ref(1);

const form = useForm({
    _method: "PUT",
    name: props.customers?.name,
    email: props.customers?.email,
    address: props.customers?.address,
    country: props.customers?.country || "Congo",
    contact: props.customers?.contact,
    telephone: props.customers?.telephone,
    fiscal_code: props.customers?.fiscal_code,
    description: props.customers?.description,
    solde: props.customers?.solde,
    active: props.customers?.active,
});

const submit = () => {
    form.post(route('customers.update', props.customers.id), {
        //onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Details Client">

        <div class="py-8 px-3 bg-white">
            <div class="flex flex-row justify-between">
                <div>
                    <div class="text-sm text-gray-500">
                        Acceuil /
                        <Link class="text-gray-600 hover:text-gray-800" :href="route('customers.index')">Client</Link>
                    </div>
                    <div class="flex">
                        <h3 class=" mt-3 font-extrabold text-2xl text-gray-900">
                            {{ customers?.name }}
                        </h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-3 text-green-500 hidden lg:block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>

                    <div class="grid grid-cols-2 gap-4 md:flex md:gap-4 mt-3 text-gray-500 font-semibold">
                        <div class="text-sm flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ customers?.telephone }} </span>
                        </div>
                        <div class="text-sm flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ customers?.solde / 100 }} XAF</span>
                        </div>
                        <div class="text-sm flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ customers?.address }} </span>
                        </div>
                        <div v-if="customers?.active" class="text-sm flex gap-1 text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <span>Actif</span>
                        </div>

                    </div>
                </div>

                <div class="flex flex-row justify-end max-h-10">
                    <Link :href="route('payments.create') + '?customer_id=' + props.customers.id"
                        class="flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Ajouter Paiement
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                    <Link :href="route('orders.create') + '?customer_id=' + props.customers.id"
                        class="flex items-center justify-between w-42 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Creer une Facture
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <AlertBox :flash="$page.props.flash" :on="true" class="mr-3">

                </AlertBox>

                <section class=" bg-gray-50">
                    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b pl-0 mb-4"
                        id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation cursor-pointer">
                            <span href="#tabs-home" class="nav-link block font-medium text-sm leading-tight border-t-0  border-b-indigo-700
                                px-6 py-3  hover:border-b-indigo-700 hover:bg-indigo-100 focus:border-transparent" :class="{ 'text-indigo-800 border-b-2': tabs_position==1}"
                                @click="tabs_position=1">Details</span>
                        </li>
                        <li class="nav-item" role="presentation cursor-pointer">
                            <span href="#tabs-home" class="nav-link block font-medium text-sm leading-tight border-t-0  border-b-indigo-700
                                px-6 py-3  hover:border-b-indigo-700 hover:bg-indigo-100 focus:border-transparent" :class="{ 'text-indigo-800 border-b-2': tabs_position==2}"
                                @click="tabs_position=2">Factures</span>
                        </li>
                        <li class="nav-item" role="presentation cursor-pointer">
                            <span href="#tabs-home" class="nav-link block font-medium text-sm leading-tight border-t-0  border-b-indigo-700
                                px-6 py-3  hover:border-b-indigo-700 hover:bg-indigo-100 focus:border-transparent" :class="{ 'text-indigo-800 border-b-2': tabs_position==3}"
                                @click="tabs_position=3">Paiements</span>
                        </li>




                    </ul>
                    <div class="tab-content lg:min-h-screen "  >
                        <div v-if="tabs_position==1" class="tab-pane" role="tabpanel" aria-labelledby="tabs-home-tab">
                            <EditForm :customers="customers">
                            </EditForm>
                        </div>
                        <div v-if="tabs_position==2" class="tab-pane"  role="tabpanel" aria-labelledby="tabs-profile-tab">
                            <Invoices :customers="customers">
                            </Invoices>
                        </div>
                        <div v-if="tabs_position==3" class="px-5 py-8 .bg-gray-400"  role="tabpanel" aria-labelledby="tabs-profile-tab">
                            Aucune donnees a affiche pour l'instant...
                        </div>

                    </div>
                </section>


                <div class="mt-1">
                    <div class="w-full md:flex flex-column  lg:justify-between mx-auto py-5 sm:px-6 lg:px-8 lg:gap-2">

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
