<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '../../Jetstream/Pagination.vue';
defineProps({
    customers: Object,
});

const  formatMoney=(number) =>{
   return 'XAF '+ number.toLocaleString('en-US');
};
/*const logout = () => {
    Inertia.post(route('logout'));
};*/
</script>

<template>
    <AppLayout title="Dashboard">


        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3 class="text-xl">Custommers Management</h3>
                <div class="flex flex-row justify-end">
                    <Link :href="route('customers.create')"
                        class="flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Payment
                        <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                    <Link :href="route('customers.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Create Customer
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
                                    Solde
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in customers.data" :key="customer.id" class="bg-white dark:bg-gray-800 hover:bg-gray-100  border-t">
                                <th scope="row"
                                    class="px-6 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ customer.name }}
                                </th>
                                <td class="px-6 py-3">
                                    {{ customer?.contact }}
                                </td>

                                <td class="px-6 py-3">

                                    <span v-if="customer?.solde > 50000" class="text-red-600">
                                        {{formatMoney(customer?.solde)}}
                                    </span>
                                    <span v-if="customer?.solde <= 50000" class="text-green-600">
                                        {{formatMoney(customer?.solde)}}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <Link :href="route('customers.show', customer.id)"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</Link>
                                    <Link :href="route('payments.create')+'?customer_id='+customer.id"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Payment</Link>
                                    <Link :href="route('orders.create')+'?customer_id='+customer.id" title="Add Order"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Order</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                </div>
                <div class="mt-3 flex flex-row-reverse ">
                    <Pagination :links="customers.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
