<script setup>
import { ref, nextTick, watch, reactive, computed, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';
import JetDialogModal from '@/Jetstream//DialogModal.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    order: Object,
    customers: Object,
    company: String,
});


const form = useForm({
    _method: "PUT",
    id: props.order[0]?.id,
    customer_id: props.order[0]?.customer_id,
    order_key: props.order[0]?.order_key,
    order_status: props.order[0]?.order_status,
    date_order: props.order[0]?.date_order,
    due_date_order: props.order[0].due_date_order,
    total_order: props.order[0].total_order / 100,
    tax_1_percentage: props.order[0].tax_1_percentage,
    tax_2_percentage: props.order[0].tax_2_percentage,
    tax_1_amount: props.order[0].tax_1_amount,
    tax_2_amount: props.order[0].tax_2_amount,
    ttc_total_order: props.order[0].ttc_total_order / 100,
    order_status: props.order[0].order_status,
    order_comment: props.order[0].order_comment,
    remise_order: props.order[0].remise_order,
    ref_customer: props.order[0].ref_customer,
    products: [],
});
const messageForm = useForm({
   // order_id: props.order[0]?.id,
    _method: "PUT",
    customer_id: props.order[0]?.customer_id,
    order_key: props.order[0]?.order_key,
    subject: "",
    message: "",
});

var can_update = props.order[0]?.order_status == 1 ? true : false;
const taxTable = reactive({
    '0': 0,
    '5': 5,
    '18': 18,
    '20': 20,
});

const renderComponent = ref(true);
const formAdd = ref(true);
var milestone = null;
const openForm = ref(false);
const openMessage = ref(false);
const showAlert = ref(true);
const oneLigne = reactive({
    product_id: 1,
    name: '',
    description: '',
    is_service: true,
    //unit_price: 0,
    total_price: 0,
    total_quantity: 0,
    ligne_total: 0,
    tax: 0
});
const lignes = props.order[0]?.products;

const addLigne = () => {
    if (oneLigne.total_quantity < 1) {
        alert("Quantity must be more than one.");
        return;
    }
    if ((oneLigne.name).length < 3 && oneLigne.product_id == 1) {
        alert("Please Provide a correct description.");
        console.log((oneLigne.name).length);
        return;
    }
    oneLigne.ligne_total = Math.round(oneLigne.total_quantity * oneLigne.total_price * (1 + (oneLigne.tax / 100)) * 100) / 100;

    if (milestone == null) {
        milestone = oneLigne;

        lignes.push({ "pivot": { ...milestone } });
    } else {
        lignes[milestone].pivot = { ...oneLigne };
    }

    milestone = null;
    formAdd.value = true;
    forceRerender();
    clearForm();
    invoiceTotal();
    openForm.value = false;

};

const selectedCustomer = () => {
    if (form.customer_id == null) {
        console.log("null");
        return;
    }
    let customer_id = form.customer_id;
    for (let i = 0; i < props.customers.length; i++) {
        if (customer_id == props.customers[i].id) {
            form.solde = props.customers[i].solde;
            console.log(form.solde);
            break;
        }
    }

}

const removeItem = (index) => {
    lignes.splice(index, 1);
    invoiceTotal();
}

const EditItem = (index) => {

    console.log(index);
    formAdd.value = false;
    let data = { ...lignes[index].pivot };
    // oneLigne = data;
    formAdd.value = false;
    oneLigne.product_id = data.product_id;
    oneLigne.name = data.name;
    oneLigne.description = data.description;
    oneLigne.total_price = data.total_price;
    oneLigne.total_quantity = data.total_quantity;
    oneLigne.tax = data.tax;
    oneLigne.ligne_total = Math.round(data.total_quantity * data.total_price * (1 + (data.tax / 100)) * 100) / 100;
    milestone = index;
    toogleForm();

    //textUpdate
}

const invoiceTotal = () => {
    let total = lignes.reduce((a, b) => a + (Math.round(b.pivot.total_price * b.pivot.total_quantity * (1 + (b.pivot.tax / 100)) * 100) / 100), 0);
    console.log(total);
    form.total_order = total;
    form.tax_1_amount = (total * (form.tax_1_percentage / 100));
    form.tax_2_amount = (total * (form.tax_2_percentage / 100));
    form.ttc_total_order = total + form.tax_1_amount + form.tax_2_amount;
}

const clearForm = () => {
    oneLigne.product_id = 1;
    oneLigne.name = '';
    oneLigne.description = '';
    oneLigne.total_price = 0;
    oneLigne.total_quantity = 0;
};

const forceRerender = () => {
    renderComponent.value = false;

    nextTick(() => {
        renderComponent.value = true;
    });
}

const toogleForm = (a = 0) => {
    openForm.value = !openForm.value;
    forceRerender();
    console.log(openForm);
    if (a == 1) {
        oneLigne.ligne_total = 0;
        clearForm();
    }
}
/* watch(oneLigne, (currentValue, oldValue) => {
       console.log(currentValue);
       oneLigne.ligne_total= oneLigne.total_price*currentValue
   });*/

const cancel_order = () => {
    if (!confirm("Voulez vous annuler cette facture?")) return;
    form.order_status = 4;
    submit();
}

const submit = () => {

    lignes.forEach(item => {
        form.products.push(item.pivot)
    });
    form.post(route('orders.update', props.order[0]?.id,), {
        onSuccess: () => {
            clearForm(); form.products = [],
                showAlert.value = true;
            setTimeout(() => { showAlert.value = false }, 5000)
        },
    });
};

const validateOrder = () => {
    if (!confirm('Cette action ajoutera le total au solde du client et la facture ne sera plus modifible. Valider ?'))
        return;
    form.order_status = 2;
    submit();
}

const deleteOrder = () => {
    if (!confirm('Voulez vous supprimer cette facture?'))
        return;

    Inertia.delete(route('orders.destroy', props.order[0]?.id));
};

const openMessageModal = () => { openMessage.value=true;};
const sendMessage = () => {

    messageForm.post(route('orders.sendmessage', props.order[0]?.id,), {
        onSuccess: () => {
            messageForm.subject = ""; messageForm.message = "";
            openMessage.value=false;
        },
        onError: (e) =>{ console.log(e);  openMessage.value=true;},
        //preserveState: false,
    });

};

onMounted(() => {

})
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('orders.index')">Gestions des Facture</Link> / Facture N-
                    {{props?.order[0]?.id}}
                </h3>
                <div class="flex flex-row justify-end">
                    <span v-if="props.order[0].order_status==1" @click="validateOrder"
                        class=" cursor-pointer flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-green-600  hover:text-white transition-colors duration-150 border border-green-600 rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                        Valider
                        <span class="ml-2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </span>
                    <span v-if="props.order[0].order_status==1" @click="deleteOrder"
                        class=" cursor-pointer flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-red-600  hover:text-white transition-colors duration-150 border border-red-600 rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                        Supprimer
                        <span class="ml-2" aria-hidden="true">X</span>
                    </span>

                    <Link :href="route('orders.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Nouvelle Facture
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                    <button @click="openMessageModal"
                        class="flex ml-2 items-center justify-between w-30 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-slate-500 border border-transparent rounded-lg active:bg-slate-600 hover:bg-slate-700 focus:outline-none focus:shadow-outline-slate">
                        Mail.
                        <span class="ml-2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </span>
                    </button>
                    <a :href="'/invoices/'+props.order[0].order_key+'/'+props.order[0].id" target="_blank"
                        class="flex ml-2 items-center justify-between w-30 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                        Impr.
                        <span class="ml-2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </span>
                    </a>
                </div>

            </div>
            <div class="mt-3">
                <AlertBox v-if="showAlert" :flash="$page.props.flash" :on="showAlert" class="mr-3"></AlertBox>

                <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                    <div class="">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 py-8 rounded-lg bg-white ">

                            <form @submit.prevent="submit">
                                <div class="flex flex-col md:flex-row mb-8 md:justify-between">
                                    <div class="w-full md:w-2/4">
                                        <div class="mb-2 md:mb-5 md:flex items-center">
                                            <label
                                                class="w-full text-gray-800 block font-bold text-xl uppercase tracking-wide">Facture
                                                <span v-if="props.order[0]?.order_status == 1"
                                                    class="px-2 py-2 text-xs bg-yellow-300 text-yellow-700 rounded-xl">
                                                    Brouillon</span>
                                                <span v-if="props.order[0]?.order_status != 1"
                                                    class="px-2 py-2 text-xs bg-green-300 text-green-700 rounded-xl">
                                                    Validee</span>
                                            </label>

                                        </div>

                                        <div class="mb-2 md:mb-1 md:flex items-center">
                                            <label
                                                class="w-32 text-gray-800 block font-bold text-sm uppercase tracking-wide">Date
                                                de Facturation</label>
                                            <span class="mr-4 inline-block  md:block">:</span>
                                            <div class="flex-1">

                                                <JetInput v-model="form.date_order" type="date"
                                                    class="mt-1 block w-48 bg-gray-100 border-0"
                                                    placeholder="eg. 17 Feb, 2020" />
                                            </div>
                                        </div>

                                        <div class="mb-2 md:mb-1 md:flex items-center">
                                            <label
                                                class="w-32 text-gray-800 block font-bold text-sm uppercase tracking-wide">Délai
                                                de Paiement</label>
                                            <span class="mr-4 inline-block  md:block">:</span>
                                            <div class="flex-1">

                                                <JetInput v-model="form.due_date_order" type="date"
                                                    class="mt-1 block w-48 bg-gray-100 border-0"
                                                    placeholder="eg. 17 Feb, 2020" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" hidden md:block">
                                        <div
                                            class="w-32 h-32 mb-1 -border rounded-lg overflow-hidden relative -bg-gray-100">
                                            <!--img id="image" class="object-cover w-full h-32"
                                                src="https://placehold.co/300x300/e2e8f0/e2e8f0"-->

                                            <!--div class="absolute top-0 left-0 right-0 bottom-0 w-full block cursor-pointer flex items-center justify-center"
                                                onclick="document.getElementById('fileInput').click()">
                                                <button type="button"
                                                    style="background-color: rgba(255, 255, 255, 0.65)"
                                                    class="hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded-lg shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-camera" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                                        <path
                                                            d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2">
                                                        </path>
                                                        <circle cx="12" cy="13" r="3"></circle>
                                                    </svg>
                                                </button>
                                            </div-->
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-4 flex gap-2 flex-col md:flex-row justify-between w-full">
                                    <div class="w-full lg:w-1/3">

                                        <select class="hidden mt-1 w-full bg-gray-100 border-0 rounded"
                                            v-model="form.customer_id" @change="selectedCustomer()">
                                            <option :value="null"> Select Client</option>
                                            <template v-for="(item, index) in customers" :key="index">
                                                <option :value="item.id"> {{ item.name }}</option>
                                            </template>
                                        </select>
                                        <div class="mb-2">
                                            <vSelect v-model="form.customer_id" :options="customers" :reduce="country => country.id" label="name" placeholder="Select. un Client" ></vSelect>
                                        </div>
                                        <h4 class="mt-1 block w-full bg-gray-100 border-0 rounded p-2" title="Solde">
                                            {{ parseInt(form.solde)/100 }}</h4>
                                        <JetInput v-model="form.ref_customer" type="text"
                                            class="mt-1 block w-full bg-gray-100 border-0" placeholder="Reference" />

                                    </div>


                                    <div class="w-full lg:w-1/3">
                                        <h5>De</h5>
                                        <h4 class="mt-1 block w-full bg-gray-100 border-0 rounded p-2">{{ company }}
                                        </h4>

                                    </div>
                                </div>



                                <div class="w-full">

                                    <table v-if="renderComponent"
                                        class="w-full overflow-x-scroll text-sm text-left text-gray-500 dark:text-gray-400 mt-5">
                                        <thead
                                            class="text-xs bold text-gray-700 uppercase border-b  dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Designation
                                                </th>

                                                <th scope="col" class="px-6 py-3">
                                                    Quantite
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    P. Unit.
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Montant Total
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    <span class="sr-only">Action</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <template v-for="(item, index) in lignes" :key="index">
                                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100">
                                                    <td scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                        <span class="font-bold">{{ item.pivot.name }}</span>
                                                        <div class=" max-w-xl  text-sm">{{ item.pivot.description }}
                                                        </div>

                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.pivot.total_price }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.pivot.total_quantity }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.pivot.total_price * item.pivot.total_quantity }}
                                                    </td>
                                                    <td class="px-6 py-4 text-right flex gap-2">
                                                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:text-blue-700"
                                                            title="Edit" @click="EditItem(index)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="1">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                        </a>
                                                        <a class="font-medium text-red-500 dark:text-blue-500 hover:text-red-700 px-2"
                                                            title="Delete" @click="removeItem(index)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="1">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </template>

                                        </tbody>
                                    </table>


                                </div>
                                <div v-if="!openForm && props.order[0]?.order_status == 1">
                                    <button
                                        class="mt-6 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded shadow-sm"
                                        v-on:click.prevent="toogleForm(1)">
                                        Ajouter une ligne
                                    </button>
                                </div>

                                <div class="mt-8 flex flex-row gap-4 w-full">
                                    <div class="w-full lg:w-1/2">
                                        <JetLabel for="description" value="Info Supplementaires" />
                                        <textarea id="description" rows="3" v-model="form.order_comment" type="text"
                                            placeholder="Informations supplementaires"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
                                    <small class="mt-2 text-indigo-900">Apparaitra sous la facture.</small>
                                    </div>
                                    <div class="py-2 ml-auto mt-3 w-full sm:w-2/4 lg:w-1/3">
                                        <div class="flex justify-between mb-3">
                                            <div class="text-gray-800 text-right flex-1">Total Brut</div>
                                            <div class="text-right w-40">
                                                <div class="text-gray-800 font-medium">{{ form.total_order }}</div>
                                            </div>
                                        </div>
                                        <div class="flex justify-between mb-4">
                                            <div class="text-sm text-gray-600 text-right flex-1">
                                                <select v-if="props.order[0]?.order_status == 1"
                                                    class="text-gray-700 block appearance-none w-full bg-gray-200 border-2 border-gray-200 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                                    v-model="form.tax_1_percentage" @change="invoiceTotal()">
                                                    <option value="0">Taxe 0%</option>
                                                    <!--option value="5">Tax 5%</option>
                                                    <option value="12">TVA 12%</option>
                                                    <option value="18">TVA 18%</option-->
                                                </select>
                                            </div>
                                            <div class="text-right w-40">
                                                <div class="text-sm text-gray-600">{{ form.tax_1_amount }}</div>
                                            </div>
                                        </div>

                                        <div class="py-2 border-t border-b">
                                            <div class="flex justify-between">
                                                <div class="text-xl text-gray-600 text-right flex-1">Montant due</div>
                                                <div class="text-right w-40">
                                                    <div class="text-xl text-gray-800 font-bold">{{ form.ttc_total_order
                                                        }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="props.order[0]?.order_status == 2"
                                    class="flex items-center justify-end mt-4">
                                    <button type="button"
                                        class="ml-4 px-4 p-2 rounded-md text-white bg-red-700 hover:bg-red-500 text-sm"
                                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                        @click="cancel_order()">
                                        Annuler cette Facture
                                    </button>
                                </div>

                                <div v-if="props.order[0]?.order_status == 1"
                                    class="flex items-center justify-end mt-4">
                                    <select class="ml-2 mt-1 block w-48 bg-gray-100 border-0 rounded"
                                        v-model="form.order_status">
                                        <option :value="1"> A confirmer</option>
                                        <option :value="2"> Validee</option>
                                    </select>

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


            <JetDialogModal :show="openForm" @close="toogleForm">
                <template #title>

                    <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">
                        <span class=" inline-block flex-1 mr-2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </span><span class=" inline-block">Veuillez ajouter une ligne</span>
                    </h2>
                </template>

                <template #content>

                    <div class="w-full rounded-lg bg-white overflow-hidden  block ">


                        <div class="mb-4">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Description</label>
                            <JetInput v-model="oneLigne.name" type="text" placeholder="Designation Produit"
                                class="mt-1 block w-full" />
                        </div>

                        <div class="flex flex-column md:flex-row">
                            <div class="mb-4 sm:w-full md:w-20 mr-2">
                                <label
                                    class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Unités</label>
                                <JetInput id="qty" v-model="oneLigne.total_quantity" type="number"
                                    placeholder="Quantite" class="mt-1 block w-full" />
                            </div>

                            <div class="mb-4 sm:w-full md:w-32 mr-2">
                                <label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Prix
                                    Unitaire</label>
                                <JetInput id="pu" v-model="oneLigne.total_price" type="number"
                                    placeholder="Prix Unitaire" class="mt-1 block w-full" />
                            </div>
                            <div class="mb-4 sm:w-full md:w-32 mr-2">
                                <label
                                    class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Taxe</label>
                                <select class="mt-1 block w-full bg-gray-100 border-0 rounded" v-model="oneLigne.tax">

                                    <template v-for="(item, index) in taxTable" :key="index">
                                        <option :value="item"> {{ item }}
                                        </option>
                                    </template>
                                </select>
                            </div>

                            <div class="mb-4 sm:w-full md:w-40">
                                <label
                                    class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Montant
                                    Total</label>
                                <span class="mt-1 block w-full px-5 py-2 rounded  border border-black "
                                    readonly="true">{{ oneLigne.ligne_total }}</span>
                            </div>
                        </div>



                    </div>
                </template>

                <template #footer>
                    <JetSecondaryButton @click="toogleForm">
                        Fermer
                    </JetSecondaryButton>

                    <JetButton v-if="formAdd" class="ml-3" @click="addLigne">
                        Ajouter
                    </JetButton>

                    <JetButton v-if="!formAdd" class="ml-3" @click="addLigne">
                        Modifier
                    </JetButton>
                </template>
            </JetDialogModal>

            <!--Dialog of Messassage -->
            <JetDialogModal :show="openMessage" @close="openMessage = !openMessage">
                <template #title>

                    <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">
                        <span class=" inline-block flex-1 mr-2" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </span><span class=" inline-block">Envoyez un mail pour cette facture</span>
                    </h2>
                </template>

                <template #content>

                    <div class="w-full rounded-lg bg-white overflow-hidden  block ">

                        <div class="mb-4">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Objet</label>
                            <JetInput v-model="messageForm.subject" type="text" placeholder="Ex: Precision FactureX-001 "
                                class="mt-1 block w-full" />
                        </div>
                        <div class="mb-4">
                            <label
                                class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Message</label>
                                 <textarea id="description" rows="3" v-model="messageForm.message" type="text"
                                            placeholder="Contenu du message"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>

                        </div>

                    </div>
                </template>

                <template #footer>
                    <JetSecondaryButton @click="openMessage = !openMessage">
                        Fermer
                    </JetSecondaryButton>

                    <JetButton class="ml-3" @click="sendMessage">
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
