<script setup>
import { ref,onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';
import Pagination from '../../Jetstream/Pagination.vue';
import OrderStatusBadge from '../../Components/OrderStatusBadge.vue';
import Helper from '@/helper.js'
defineProps({
    orders: Object,
});


const showAlert =ref(true);

onMounted(() =>{
    setTimeout(() =>{ showAlert.value=false;},3500);
})
</script>

<template>
    <AppLayout title="Custommers Management">


        <div class="py-8 xl:px-10 px-3">
            <div class="flex flex-row justify-between">
                <h3 class="text-xl">Gestion des Factures</h3>
                <div class="flex flex-row justify-end">
                    <!--Link :href="route('orders.create')"
                        class="flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Paiement
                        <span class="ml-2" aria-hidden="true">+</span>
                    </Link-->
                    <Link :href="route('orders.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Nouvelle Facture
                        <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <AlertBox v-if="showAlert" :flash="$page.props.flash" :on="showAlert" class="mb-3"></AlertBox>

                <div class="bg-white overflow-auto shadow-xl sm:rounded-lg">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                   Ref
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Client
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Montant
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders.data" :key="order.id" class="bg-white dark:bg-gray-800 hover:bg-gray-100 border-t">
                                <th scope="row"
                                    class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    ORD- {{ order.id }}
                                </th>
                                <td class="px-6 py-2">
                                    <p class=" font-bold">{{ order?.customer.name }} </p>
                                    <p class="">{{ order?.ref_customer }}</p>

                                </td>
                                <td class="px-6 py-2">
                                    <OrderStatusBadge :status="order?.order_status"></OrderStatusBadge>
                                </td>
                                <td class="px-6 py-2">
                                    {{ Helper.formatMoney(order?.ttc_total_order/100)}}
                                </td>
                                <td class="px-6 py-2 text-right">
                                    <div class="md:flex md:items-end">

                                    <Link :href="route('orders.edit', order.id)"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Détails</Link>
                                    <Link :href="route('orders.clone', order.id)" title="Dupliquer et modifier"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:text-blue-900 max-w w-8 overflow-hidden pl-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                    </Link>
                                    <a :href="'invoices/'+order.order_key+'/'+order.id" target="_blank"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2" title="Voir la facture">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                </div>
                <div class="mt-3 flex flex-row-reverse ">
                    <Pagination :links="orders.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
