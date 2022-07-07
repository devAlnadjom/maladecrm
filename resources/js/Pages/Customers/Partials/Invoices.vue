<script setup>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';

const props = defineProps({
    customers: Object,
});

const invoices = ref([]);

const showInvoices = () => {
    return axios.get('/customers/' + props.customers?.id + '?view=invoices').then(response => {
        invoices.value = response.data;
        console.log(response.data);
    });
};

const formatMoney = (number) => {
    return number.toLocaleString('en-US') + ' XAF';
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
        <div class="w-full md:flex flex-column  lg:justify-between mx-auto py-5 sm:px-6 lg:px-8 lg:gap-2">
            <div class="  lg:flex-1 ">
                <h3 class="text-bold text-lg"> Factures </h3>
                <!--p class="text-sm mb-4">Mettez un commentaires si possible</p-->
            </div>

            <div class="w-full md:w-2/3 lg:w-3/4 border rounded-md overflow-hidden shadow">
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
                        <tr v-if="! invoices.length" class="bg-white dark:bg-gray-800  border-t">
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

                                <span v-if="order?.order_status == 1"
                                    class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    A Confirmer
                                </span>
                                <span v-if="order?.order_status == 2"
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    Validee
                                </span>
                                <span v-if="order?.order_status == 3"
                                    class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    Payee
                                </span>
                                <span v-if="order?.order_status == 4"
                                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    Annullee
                                </span>
                            </td>
                            <td class="px-6 py-2">

                                {{ formatMoney(order?.ttc_total_order / 100) }}
                            </td>
                            <td class="px-6 py-2 text-right">
                                <Link :href="route('orders.edit', order.id)"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Details</Link>
                                <a :href="'invoices/' + order.order_key + '/' + order.id" target="_blank"
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
