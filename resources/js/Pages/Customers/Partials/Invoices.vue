<script setup>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';
import OrderStatusBadge from '../../../Components/OrderStatusBadge.vue';

const props = defineProps({
    customers: Object,
});

const invoices = ref([]);
const invoices_count = ref(0);
const invoices_validated = ref(0);
const sum_validated = ref(0);

const showInvoices = () => {
    return axios.get('/customers/' + props.customers?.id + '?view=invoices').then(response => {
        invoices.value = response.data?.invoices;
        invoices_count.value = response.data?.count_invoices;
        invoices_validated.value = response.data?.validated_orders;
        sum_validated.value = response.data?.validated_sum;
        console.log(response.data);
    });
};

const formatMoney = (number) => {
    let val = parseInt(number);
    if (isNaN(val))
        return 0 + " XAF";
    return val.toLocaleString('en-US') + ' XAF ';
};

onMounted(() => {
    //alert("Yooo");
    showInvoices();
});

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


</script>

<template>
    <!--AlertBox :flash="$page.props.flash" :on="true" class="mr-3">

                </AlertBox-->
    <div class="mt-1">
        <div class="w-full md:flex flex-column  lg:justify-between mx-auto py-5 sm:px-6 lg:px-8 lg:gap-4">
            <div class="  lg:flex-1 ">
                <!--h3 class="text-bold text-lg"> Factures </h3-->

                <div
                    class="container flex flex-col mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow mr-6">
                    <div class="px-4 py-5 sm:px-6 border-b w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Statistiques
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-200">
                            Informations des factures sur l'annee en cours
                        </p>
                    </div>
                    <ul class="flex flex-col divide divide-y w-full">
                        <li class="flex flex-row">
                            <div class="select-none cursor-pointer flex flex-1 items-center p-3">
                                <div class="flex flex-col w-8 h-8 justify-center items-center mr-1">
                                    <div
                                        class="p-2 mr-1 text-green-500 bg-blue-100 rounded-full dark:text-green-100 dark:bg-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 pl-1 mr-16">
                                    <div class="font-medium dark:text-white">
                                        Valides
                                    </div>

                                </div>
                                <div class="text-gray-600 dark:text-gray-200 text-xs">
                                    <span class=".text-xl">{{ invoices_validated }}</span> / <span class=".text-3xl">{{
                                            invoices_count
                                    }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="flex flex-row">
                            <div class="select-none cursor-pointer flex flex-1 items-center p-3">
                                <div class="flex flex-col w-8 h-8 justify-center items-center mr-1">
                                    <div
                                        class="p-2 mr-1 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" stroke-width="1">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 pl-1 mr-16">
                                    <div class="font-medium dark:text-white">
                                        Total
                                    </div>

                                </div>
                                <div class="text-gray-600 dark:text-gray-200 text-xs">
                                    {{ formatMoney(sum_validated / 100) }}
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>

                <!--p class="text-sm mb-4">Mettez un commentaires si possible</p-->
            </div>

            <div class="w-full md:w-2/3 mt-4 md:mt-0   border rounded-md overflow-auto shadow">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400  ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ref
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
                        <tr v-if="!invoices.length" class="bg-white dark:bg-gray-800  border-t">
                            <td colspan="5" class="px-6 py-8">
                                <p class="text-2xl text-gray-600 text-center"> Aucune Facture pour l'instant.</p>
                            </td>
                        </tr>
                        <tr v-for="order in invoices" :key="order.id"
                            class="bg-white dark:bg-gray-800 hover:bg-gray-100 border-t">
                            <th scope="row"
                                class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                ORD- {{ order.id }}
                            </th>
                            <td class="px-6 py-2">
                                <p class="">{{ order?.ref_customer }}</p>
                            </td>

                            <td class="px-6 py-2">
                                <OrderStatusBadge :status="order?.order_status"></OrderStatusBadge>
                            </td>
                            <td class="px-6 py-2">

                                {{ formatMoney(order?.ttc_total_order / 100) }}
                            </td>
                            <td class="px-6 py-2 text-right">
                                <Link :href="route('orders.edit', order.id)"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Détails</Link>
                                <a :href="'/invoices/' + order.order_key + '/' + order.id" target="_blank"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2"
                                    title="Voir la facture">Facture</a>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</template>
