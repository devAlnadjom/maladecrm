<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '../../Jetstream/Pagination.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';
import Helper from '@/helper.js'
defineProps({
    payments: Object,
});



</script>

<template>
    <AppLayout title="Dashboard">


        <div class="py-8 xl:px-10 px-3">
            <div class="flex flex-row justify-between">
                <h3 class="text-xl">Gestion des Paiement Clients</h3>
                <div class="flex flex-row justify-end">

                    <Link :href="route('payments.create')"
                        class="flex items-center justify-between w-44 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Nouveau Paiement
                        <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <AlertBox :flash="$page.props.flash" :on="true" class="mb-3"></AlertBox>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                   Client
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Methode de Paie.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                   Montant
                                </th>
                                <!--th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="payment in payments.data" :key="payment.id" class="bg-white dark:bg-gray-800 hover:bg-gray-100 border-t">
                                <td scope="row"
                                    class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    PAY-0{{ payment.id }}
                                    <p>{{ payment?.customer?.name }}</p>
                                </td>
                                <td class="px-6 py-2">
                                    {{ payment?.date }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ payment?.method}}
                                </td>
                                <td class="px-6 py-2">
                                    {{ Helper.formatMoney(payment?.montant/100)}}
                                </td>
                                <!--td class="px-6 py-2 text-right">
                                    <Link :href="route('payments.show', payment.id)"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</Link>
                                </td-->
                            </tr>
                        </tbody>
                    </table>



                </div>
                <div class="mt-3 flex flex-row-reverse ">
                    <Pagination :links="payments.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
