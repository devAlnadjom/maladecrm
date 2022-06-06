<script setup>
import { ref, nextTick } from 'vue';
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
});

const renderComponent = ref(true);

const oneLigne = {
    name: '',
    description: '',
    unit_price: 0,
    total_price: 0,
    quantity_price: 0,
};
const lignes = Array();

const addLigne = () => {

    lignes.push(oneLigne);

    oneLigne.name = '';
    oneLigne.description = '';
    oneLigne.unit_price = 0;
    oneLigne.total_price = 0;
    oneLigne.quantity_price = 0;
    forceRerender();
   // event.preventDefault();
};

 const forceRerender=()=> {
        // Removing my-component from the DOM
        renderComponent.value = false;

        nextTick(() => {
          // Adding the component back in
          renderComponent.value = true;
        });
      }

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
                        <div class="border p-4 rounded-sm">
                            <form @submit.prevent="submit">

                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="contact" value="Contact" />
                                        <JetInput id="contact" v-model="form.contact" type="text"
                                            class="mt-1 block w-full" />
                                    </div>


                                    <div class="w-full">
                                        <JetLabel for="telephone" value="Telephone" />
                                        <JetInput id="telephone" v-model="form.telephone" type="text"
                                            class="mt-1 block w-full" />
                                    </div>
                                </div>
                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="address" value="address" />
                                        <JetInput id="address" v-model="form.address" type="text"
                                            class="mt-1 block w-full" />
                                    </div>


                                    <div class="w-full">
                                        <JetLabel for="fiscal_code" value="Identifiant Fiscal" />
                                        <JetInput id="fiscal_code" v-model="form.fiscal_code" type="text"
                                            class="mt-1 block w-full" />
                                    </div>
                                </div>
                                <h3 class=" text-2xl mt-3">Info Commandes</h3>
                                <hr class="mt-1" />

                                <div class=".bg-gray-300">

                                    <table v-if="renderComponent" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100">
                                                <td scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    <span>SERVICES</span>
                                                    <div class=" max-w-xl  text-sm">lorem ipsum Lorem ipsum dolor sit
                                                        amet consectetur adipisicing elit. Accusamus laborum maiores
                                                        natus hic commodi maxime.</div>

                                                </td>
                                                <td class="px-6 py-4">
                                                    140000
                                                </td>
                                                <td class="px-6 py-4">
                                                    1
                                                </td>
                                                <td class="px-6 py-4">
                                                    14000
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <a
                                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                    <a
                                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Delete</a>
                                                </td>
                                            </tr>
                                            <template v-for="(lign, index) in lignes" :key="index">
                                             <tr
                                                class="bg-white dark:bg-gray-800 hover:bg-gray-100">
                                                <td scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    <span>SERVICES</span>
                                                    <div class=" max-w-xl  text-sm">lorem ipsum Lorem ipsum dolor sit
                                                        amet consectetur adipisicing elit. Accusamus laborum maiores
                                                        natus hic commodi maxime.</div>

                                                </td>
                                                <td class="px-6 py-4">
                                                    140000
                                                </td>
                                                <td class="px-6 py-4">
                                                    1
                                                </td>
                                                <td class="px-6 py-4">
                                                    14000
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <a
                                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                    <a
                                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Delete</a>
                                                </td>
                                            </tr>
                                            </template >

                                        </tbody>
                                    </table>

                                    <div class="mt-4 flex flex-row gap-1 w-full">
                                        <div class="w-2/5">
                                            <JetLabel for="address" value="Nom" />
                                            <JetInput id="address" v-model="form.address" type="text"
                                                class="mt-1 block w-full" />
                                        </div>


                                        <div class="w-1/5">
                                            <JetLabel for="fiscal_code" value="Quantite" />
                                            <JetInput id="fiscal_code" v-model="form.fiscal_code" type="text"
                                                class="mt-1 block w-full" />
                                        </div>
                                        <div class="w-1/5">
                                            <JetLabel for="fiscal_code" value="PU" />
                                            <JetInput id="fiscal_code" v-model="form.fiscal_code" type="text"
                                                class="mt-1 block w-full" />
                                        </div>
                                        <div class="w-1/5">
                                            <JetLabel for="fiscal_code" value="Pt" />
                                            <JetInput id="fiscal_code" v-model="form.fiscal_code" type="text"
                                                class="mt-1 block w-full" />
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end mt-4 gap-4">
                                        <button class="underline text-sm text-gray-600 hover:text-gray-900">
                                            Clear
                                        </button>

                                        <button type="button" class="underline text-sm px-4 py-1 rounded  border border-black hover:bg-black hover:text-white text-black "
                                            v-on:click.prevent="addLigne" >
                                            Add
                                        </button>
                                    </div>
                                </div>

                                <h3 class=" text-2xl mt-3">Info Commandes</h3>
                                <hr class="mt-1" />
                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="description" value="description" />
                                        <textarea id="description" rows="3" v-model="form.description" type="text"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
                                    </div>


                                    <div class="w-full">
                                        <JetLabel for="solde" value="Solde Courant" />
                                        <JetInput id="solde" v-model="form.solde" type="number"
                                            class="mt-1 block w-full" />

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
