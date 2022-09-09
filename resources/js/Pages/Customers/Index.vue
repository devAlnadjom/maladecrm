<script setup>
import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {Head, Link} from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '../../Jetstream/Pagination.vue';
import UserAdd from '../../Components/Icons/UserAdd.vue';
import AddIcon from '../../Components/Icons/AddIcon.vue';
import UsersIcon from '../../Components/Icons/UsersIcon.vue';

defineProps({
    customers: Object,
});

const formatMoney = (number) => {
    return 'XAF ' + number.toLocaleString('en-US');
};
/*const logout = () => {
    Inertia.post(route('logout'));
};*/
</script>

<template>
    <AppLayout title="Dashboard">


        <div class="py-8 xl:px-10 px-3">
            <div class="mt-5">

                <template v-if="customers.data.length > 0">
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-xl font-semibold text-gray-900">Gestion des Clients</h1>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <Link :href="route('customers.create')"
                                      class="inline-flex items-center rounded-md border border-transparent bg-purple-100 px-4 mr-2 py-2 text-sm font-medium text-purple-700 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                    Paiement
                                    <AddIcon/>
                                </Link>

                                <Link :href="route('customers.create')"
                                      class="inline-flex items-center rounded-md border border-transparent bg-purple-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                    Nouveau Client
                                    <UserAdd/>
                                </Link>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-col">
                            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">Nom / Raison Social</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Contact</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Solde</th>
                                                <th scope="col" class="relative py-3 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="customer in customers.data" :key="'customer-' + customer.id">
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"> {{ customer.name }}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ customer?.contact }}</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <span v-if="customer?.solde > 500" class="inline-flex items-center rounded-full bg-red-100 px-3 py-0.5 text-sm font-medium text-red-800">
                                                        {{ formatMoney(customer?.solde / 100) }}
                                                    </span>
                                                    <span v-if="customer?.solde <= 500" class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800">
                                                        {{ formatMoney(customer?.solde / 100) }}
                                                    </span>
                                                </td>
                                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <Link :href="route('customers.show', customer.id)"
                                                          class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Details
                                                    </Link>

                                                    <Link :href="route('payments.create')+'?customer_id='+customer.id"
                                                          class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">
                                                        Paiement
                                                    </Link>
                                                    <Link :href="route('orders.create')+'?customer_id='+customer.id" title="Add Order"
                                                          class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">
                                                        Facture
                                                    </Link>
                                                </td>
                                            </tr>

                                            <!-- More people... -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <Pagination :links="customers.links"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="text-center">
                        <UsersIcon class="mx-auto h-20 w-20 text-gray-400" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun client</h3>
                        <p class="mt-1 text-sm text-gray-500">Ajoutez un nouveau client.</p>
                        <div class="mt-6">
                            <Link :href="route('customers.create')"
                                  class="inline-flex items-center rounded-md border border-transparent bg-purple-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                Nouveau Client
                                <AddIcon/>
                            </Link>
                        </div>
                    </div>

                </template>

            </div>
        </div>
    </AppLayout>
</template>


