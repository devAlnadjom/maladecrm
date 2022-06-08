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

defineProps({
    //orders: Object,
});


const form = useForm({
    name: '',
    email: '',
    address: '',
    country: 'Congo',
    contact: '',
    telephone: '',
    fiscal_code: '',
    description: '',
    solde: 0,
    active: true,
    date_orde: null,
});

const renderComponent = ref(true);
var milestone = null;
const openForm= ref(false);
const oneLigne = reactive({
    product_id: 1,
    name: '',
    description: '',
    is_service: true,
    //unit_price: 0,
    total_price: 0,
    total_quantity: 0,
    ligne_total: computed(() => oneLigne.total_quantity * oneLigne.total_price),
});
const lignes = reactive([]);

const addLigne = () => {
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
    milestone = index;
    //textUpdate
}

const invoiceTotal = () => {
    let total = lignes.reduce((a, b) => a + b.ligne_total, 0);
    console.log(total);
    form.solde = total;
}

const clearForm = () => {

    oneLigne.product_id = 1;
    oneLigne.name = '';
    oneLigne.description = '';
    oneLigne.total_price = 0;
    oneLigne.total_quantity = 0;
};

const forceRerender = () => {
    // Removing my-component from the DOM
    renderComponent.value = false;

    nextTick(() => {
        // Adding the component back in
        renderComponent.value = true;
    });
}

const toogleForm = () => {
    openForm.value= !openForm.value;
    forceRerender();
    console.log(openForm);
}
/* watch(oneLigne, (currentValue, oldValue) => {
       console.log(currentValue);
       oneLigne.ligne_total= oneLigne.total_price*currentValue
   });*/

const submit = () => {
    form.post(route('orders.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('orders.index')">Custommers Management</Link> / Create New
                </h3>
                <div class="flex flex-row justify-end">
                    <Link :href="route('orders.create')"
                        class="flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Payment
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                    <Link :href="route('orders.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Create order
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 py-8 rounded-lg bg-white ">

                            <form @submit.prevent="submit">
                                <div class="flex mb-8 justify-between">
                                    <div class="w-2/4">
                                        <div class="mb-2 md:mb-1 md:flex items-center">
                                            <label
                                                class="w-32 text-gray-800 block font-bold text-sm uppercase tracking-wide">Facture
                                                No.</label>
                                            <span class="mr-4 inline-block hidden md:block">:</span>
                                            <div class="flex-1">
                                                <input
                                                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-48 py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                                    id="inline-full-name" type="text" placeholder="eg. #INV-100001"
                                                    >
                                            </div>
                                        </div>

                                        <div class="mb-2 md:mb-1 md:flex items-center">
                                            <label
                                                class="w-32 text-gray-800 block font-bold text-sm uppercase tracking-wide">Date
                                                de Facturation</label>
                                            <span class="mr-4 inline-block hidden md:block">:</span>
                                            <div class="flex-1">

                                                    <JetInput  v-model="form.date_orde" type="date"
                                                        class="mt-1 block w-48 bg-gray-100 border-0" placeholder="eg. 17 Feb, 2020" />
                                            </div>
                                        </div>

                                        <div class="mb-2 md:mb-1 md:flex items-center">
                                            <label
                                                class="w-32 text-gray-800 block font-bold text-sm uppercase tracking-wide">Délai
                                                de Paiement</label>
                                            <span class="mr-4 inline-block hidden md:block">:</span>
                                            <div class="flex-1">

                                                    <JetInput  v-model="form.date_orde" type="date"
                                                        class="mt-1 block w-48 bg-gray-100 border-0" placeholder="eg. 17 Feb, 2020" />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div
                                            class="w-32 h-32 mb-1 border rounded-lg overflow-hidden relative bg-gray-100">
                                            <img id="image" class="object-cover w-full h-32"
                                                src="https://placehold.co/300x300/e2e8f0/e2e8f0">

                                            <div class="absolute top-0 left-0 right-0 bottom-0 w-full block cursor-pointer flex items-center justify-center"
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
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-4 flex flex-row justify-between w-full">
                                    <div class="w-full lg:w-1/3">
                                        <h5>Client</h5>
                                        <JetInput id="contact" v-model="form.contact" type="text"
                                            class="mt-1 block w-full bg-gray-100 border-0" placeholder="Contact" />
                                        <JetInput id="telephone" v-model="form.telephone" type="text"
                                            class="mt-1 block w-full bg-gray-100 border-0" placeholder="Telephone" />
                                        <JetInput id="address" v-model="form.address" type="text"
                                            class="mt-1 block w-full bg-gray-100 border-0" />

                                        <JetInput id="fiscal_code" v-model="form.fiscal_code" type="text"
                                            class="mt-1 block w-full bg-gray-100 border-0" />
                                    </div>


                                    <div class="w-full lg:w-1/3">
                                        <h5>De</h5>
                                        <JetInput id="contact" v-model="form.contact" type="text"
                                            class="mt-1 block w-full bg-gray-100 border-0" placeholder="Contact" />
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
                                                    Pu
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Qt
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
                                                        <span CLASS="font-bold">{{ item.name }}</span>
                                                        <div class=" max-w-xl  text-sm">lorem ipsum Lorem ipsum dolor
                                                            sit
                                                            amet consectetur adipisicing elit. </div>

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
                                                    <td class="px-6 py-4 text-right">
                                                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                            @click="EditItem(index)">Edit</a>
                                                        <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2"
                                                            @click="removeItem(index)">Delete</a>
                                                    </td>
                                                </tr>
                                            </template>

                                        </tbody>
                                    </table>

                                    <div v-if="renderComponent && openForm" class="mt-5 flex flex-row gap-1 w-full">
                                        <div class="w-1/2">
                                            <JetLabel for="address" value="Nom" />
                                            <JetInput id="address" v-model="oneLigne.name" type="text"
                                                class="mt-1 block w-full" />
                                        </div>


                                        <div class="w-1/6">
                                            <JetLabel for="qty" value="Quantite" />
                                            <JetInput id="qty" v-model="oneLigne.total_quantity" type="number"
                                                class="mt-1 block w-full" />
                                        </div>
                                        <div class="w-2/6">
                                            <JetLabel for="pu" value="PU" />
                                            <JetInput id="pu" v-model="oneLigne.total_price" type="number"
                                                class="mt-1 block w-full" />
                                        </div>
                                        <div class="w-2/6">
                                            <JetLabel for="" value="Pt" />
                                            <span class="mt-1 block w-full px-5 py-2 rounded  border border-black "
                                                readonly="true">{{ oneLigne.ligne_total }}</span>
                                        </div>
                                        <div class="w-1/6">

                                            <button type="button" v-if="milestone !== null"
                                                class="text-sm my-5 px-4 py-1 rounded  border border-black hover:bg-black hover:text-white text-black "
                                                v-on:click.prevent="addLigne">
                                                Update
                                            </button>
                                            <button type="button" v-if="milestone === null"
                                                class="text-sm px-4 mt-6 py-2 rounded  border border-black hover:bg-black hover:text-white text-black "
                                                v-on:click.prevent="addLigne">
                                                + Add
                                            </button>
                                            <button type="button" v-if="milestone === null"
                                                class="text-sm px-4 mt-6 py-1 rounded  hover:text-red-500 text-red-900 hover:overline"
                                                v-on:click.prevent="toogleForm">
                                                Close
                                            </button>

                                        </div>
                                    </div>

                                </div>
                                <div  v-if="!openForm">
                                    <button class="mt-6 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded shadow-sm" v-on:click.prevent="toogleForm">
                                        Ajouter une ligne
                                    </button>
                                </div>

                                <div class="mt-8 flex flex-row gap-4 w-full">
                                    <div class="w-full lg:w-1/2">
                                        <JetLabel for="description" value="Info Supplementaires" />
                                        <textarea id="description" rows="3" v-model="form.description" type="text"
                                            placeholder="Fill for extra information"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
                                    </div>
                                    <div class="py-2 ml-auto mt-3 w-full sm:w-2/4 lg:w-1/3">
                                        <div class="flex justify-between mb-3">
                                            <div class="text-gray-800 text-right flex-1">Total incl. Taxe</div>
                                            <div class="text-right w-40">
                                                <div class="text-gray-800 font-medium">{{ form.solde }}</div>
                                            </div>
                                        </div>
                                        <div class="flex justify-between mb-4">
                                            <div class="text-sm text-gray-600 text-right flex-1">Taxe incl. Total</div>
                                            <div class="text-right w-40">
                                                <div class="text-sm text-gray-600">0</div>
                                            </div>
                                        </div>

                                        <div class="py-2 border-t border-b">
                                            <div class="flex justify-between">
                                                <div class="text-xl text-gray-600 text-right flex-1">Montant due</div>
                                                <div class="text-right w-40">
                                                    <div class="text-xl text-gray-800 font-bold">0</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <JetLabel for="active">
                                        <div class="flex items-center">
                                            <JetCheckbox id="active" v-model:checked="form.active" name="active" />

                                            <div class="ml-2">
                                                Active
                                            </div>
                                        </div>
                                    </JetLabel>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button class="underline text-sm text-gray-600 hover:text-gray-900">
                                        Clear
                                    </button>

                                    <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Submit
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
