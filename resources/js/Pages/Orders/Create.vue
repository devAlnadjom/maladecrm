<script setup>
import { ref, nextTick, watch, reactive, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import JetDialogModal from '@/Jetstream//DialogModal.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
//import vSelect from 'vue-select'


const props = defineProps({
    //orders: Object,
    customers: Object,
    company: String,
    customer_id: Object,
});


const form = useForm({

    customer_id: props.customer_id,
    date_order: null,
    due_date_order: null,
    total_order: 0,
    tax_1_percentage: 0,
    tax_2_percentage: 0,
    tax_1_amount: 0,
    tax_2_amount: 0,
    ttc_total_order: 0,
    order_status: 1,
    order_comment: '',
    remise_order: 0,
    ref_customer: '',
    order_type: 0,
    products: null,

    solde: 0,
});

const renderComponent = ref(true);
var milestone = null;
const openForm = ref(false);
const oneLigne = reactive({
    product_id: 1,
    name: '',
    description: '',
    is_service: true,
    //unit_price: 0,
    tax:0,
    total_price: 0,
    total_quantity: 0,
    ligne_total: computed(() => Math.round(oneLigne.total_quantity * oneLigne.total_price* (1 + (oneLigne.tax/100))*100) /100),
});
const lignes = reactive([]);
const formAdd = ref(true);
const taxTable= reactive({
    '0':0,
    '5':5,
    '18':18,
    '20':20,
});

const addLigne = () => {
    if (oneLigne.total_quantity < 1) {
        alert("La quantitee doit etre superieur a 1.");
        return;
    }
    if ((oneLigne.name).length < 3 && oneLigne.product_id == 1) {
        alert("Veuillez fournir la description du produit a ajouter.");
        console.log((oneLigne.name).length);
        return;
    }

    if (milestone == null) {
        milestone = oneLigne;
        lignes.push({ ...milestone });
    } else {
        lignes[milestone] = { ...oneLigne };
    }

    milestone = null;
    forceRerender();
    clearForm();
    invoiceTotal();
    openForm.value =false;
    formAdd.value =true;

};

const removeItem = (index) => {
    lignes.splice(index, 1);
    invoiceTotal();
}

const EditItem = (index) => {
    let data = { ...lignes[index] };
    // oneLigne = data;
    oneLigne.product_id = data.product_id;
    oneLigne.name = data.name;
    oneLigne.description = data.description;
    oneLigne.total_price = data.total_price;
    oneLigne.total_quantity = data.total_quantity;
    oneLigne.tax = data.tax;
    milestone = index;
    openForm.value= true;
    formAdd.value =false;
    //textUpdate
}

const selectedCustomer = () => {
    if (form.customer_id == null) {
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

const invoiceTotal = () => {
    let total = lignes.reduce((a, b) => a + b.ligne_total, 0);
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
    oneLigne.tax = 0;
};

const forceRerender = () => {
    renderComponent.value = false;

    nextTick(() => {
        renderComponent.value = true;
    });
}

const toogleForm = () => {
    openForm.value = !openForm.value;
    forceRerender();
    console.log(openForm);
}


const submit = () => {
    if (form.customer_id == null) {
        alert("Veuillez selectionner un clients");
        return;
    }
    if (form.ttc_total_order == 0) {
        if (!confirm("Le montant de cette facture est 0. Voulez vous continuer?"))
            return;
    }
    if (form.order_type == 1) {
        if (!confirm("Cette facture est definie compant. Voulez vous continuer?"))
            return;
    }
    form.products = lignes;

    form.post(route('orders.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('orders.index')">Gestions de Facturations</Link> / Ajouter
                    Nouveau
                </h3>
                <div class="flex flex-row justify-end">
                    <!--Link :href="route('orders.create')"
                        class="flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Payment
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                    <Link :href="route('orders.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Create order
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link-->
                </div>

            </div>
            <div class="mt-3">
                <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                    <div class="">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 py-8 rounded-lg bg-white ">

                            <form @submit.prevent="submit">
                                <div class="flex mb-8 justify-between">
                                    <div class="w-2/4">
                                        <div class="mb-2 md:mb-5 md:flex items-center">

                                            <select
                                                class="pl-0 w-42 text-gray-800 block font-bold text-xl uppercase mt-1  border-0 rounded"
                                                v-model="form.order_type">
                                                <option :value="0"> Facture Credit</option>
                                                <option :value="1"> Facture Comptant</option>
                                            </select>
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
                                            <span class="mr-4 inline-block md:block">:</span>
                                            <div class="flex-1">

                                                <JetInput v-model="form.due_date_order" type="date"
                                                    class="mt-1 block w-48 bg-gray-100 border-0"
                                                    placeholder="ex. 17 04 2020" />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div
                                            class="w-32 h-32 mb-1 .border rounded-lg overflow-hidden relative -bg-gray-100">
                                            <!--img id="image" class="object-cover w-full h-32"
                                                src="https://placehold.co/300x300/e2e8f0/e2e8f0"-->

                                            <div class="absolute top-0 left-0 right-0 bottom-0 w-full cursor-pointer flex items-center justify-center"
                                                onclick="document.getElementById('fileInput').click()">
                                                <!--button type="button"
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
                                                </button-->
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-4 flex flex-row justify-between w-full">
                                    <div class="w-full lg:w-1/3">

                                        <select class="mt-1 block w-full bg-gray-100 border-0 rounded"
                                            v-model="form.customer_id" @change="selectedCustomer()">
                                            <option :value="null"> Select Client</option>
                                            <template v-for="(item, index) in customers" :key="index">
                                                <option :value="item.id"> {{item.name}}</option>
                                            </template>
                                        </select>
                                        <h4 class="mt-1 block w-full bg-gray-100 border-0 rounded p-2" title="Solde">
                                            {{(form.solde/100)}}</h4>
                                        <JetInput v-model="form.ref_customer" type="text"
                                            class="mt-1 block w-full bg-gray-100 border-0" placeholder="Reference" />

                                    </div>


                                    <div class="w-full lg:w-1/3">
                                        <h5>De</h5>
                                        <h4 class="mt-1 block w-full bg-gray-100 border-0 rounded p-2">{{company}}</h4>
                                    </div>
                                </div>



                                <div class="">

                                    <table v-if="renderComponent"
                                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-5">
                                        <thead
                                            class="text-xs bold text-gray-700 uppercase border-b  dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Designation
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    P. Unit.
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Quantity
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
                                                        <span class="font-bold">{{ item.name }}</span>
                                                        <div class=" max-w-xl  text-sm">{{item.description}}</div>

                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.total_price }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.total_quantity }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ item.ligne_total }}
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
                                <div v-if="!openForm">
                                    <button
                                        class="mt-6 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded shadow-sm"
                                        v-on:click.prevent="toogleForm">
                                        Ajouter une ligne
                                    </button>
                                </div>

                                <div class="mt-8 flex flex-row gap-4 w-full">
                                    <div class="w-full lg:w-1/2">
                                        <JetLabel for="description" value="Info Supplementaires" />
                                        <textarea id="description" rows="3" v-model="form.order_comment" type="text"
                                            placeholder="Fill for extra information"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
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
                                                <select
                                                    class="text-gray-700 block appearance-none w-full bg-gray-200 border-2 border-gray-200 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                                    v-model="form.tax_1_percentage" @change="invoiceTotal()">
                                                    <option value="0">Taxe 0%</option>
                                                    <option value="5">Tax 5%</option>
                                                    <option value="12">TVA 12%</option>
                                                    <option value="18">TVA 18%</option>
                                                </select>
                                            </div>
                                            <div class="text-right w-40">
                                                <div class="text-sm text-gray-600">{{form.tax_1_amount}}</div>
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


            <JetDialogModal :show="openForm" @close="toogleForm">
                <template #title>
                   <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">Veuillez ajouter une ligne</h2>
                </template>

                <template #content>

                   <div class="w-full rounded-lg bg-white overflow-hidden  block ">


					<div class="mb-4">
						<label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Description</label>
                         <JetInput v-model="oneLigne.name" type="text"
                                                placeholder="Designation Produit" class="mt-1 block w-full" />
                    </div>

					<div class="flex flex-column md:flex-row">
						<div class="mb-4 sm:w-full md:w-20 mr-2">
							<label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Unités</label>
							<JetInput id="qty" v-model="oneLigne.total_quantity" type="number"
                                                placeholder="Quantite" class="mt-1 block w-full" />
                        </div>

						<div class="mb-4 sm:w-full md:w-32 mr-2">
							<label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Prix Unitaire</label>
                            <JetInput id="pu" v-model="oneLigne.total_price" type="number"
                                                placeholder="Prix Unitaire" class="mt-1 block w-full" />
                        </div>
						<div class="mb-4 sm:w-full md:w-32 mr-2">
							<label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Taxe</label>
                            <select class="mt-1 block w-full bg-gray-100 border-0 rounded"
                                            v-model="oneLigne.tax" >

                                            <template v-for="(item, index) in taxTable" :key="index">
                                                <option :value="item"> {{ item }}
                                                </option>
                                            </template>
                            </select>
                        </div>



						<div class="mb-4 sm:w-full md:w-40">
							<label class="text-gray-800 block mb-1 font-bold text-sm uppercase tracking-wide">Montant Total</label>
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

                        <JetButton v-if="formAdd" class="ml-3"
                        @click="addLigne">
                        Ajouter
                    </JetButton>

                    <JetButton v-if="!formAdd" class="ml-3"
                        @click="addLigne">
                        Modifier
                    </JetButton>
                </template>
            </JetDialogModal>
        </div>
    </AppLayout>
</template>
