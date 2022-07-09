<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';

const props = defineProps({
    customers: Object,
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

const submit = () => {
    form.post(route('customers.update', props.customers.id), {
        //onFinish: () => form.reset(),
    });
};
const formatMoney = (number) => {
    let val = parseInt(number);
    if (isNaN(val))
        return 0 + " XAF";
    return val.toLocaleString('en-US') + ' XAF ';
};
</script>

<template>
    <!--AlertBox :flash="$page.props.flash" :on="true" class="mr-3">

                </AlertBox-->
                <div class="mt-1">
                    <div class="w-full md:flex flex-column  lg:justify-between mx-auto py-5 sm:px-6 lg:px-8 lg:gap-2">
                        <div class="  lg:flex-1 ">

                             <div
                    class="container flex flex-col mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow mr-6">
                    <div class="px-4 py-5 sm:px-6 border-b w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Infos Générales
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-200">
                            Détails suplémentaires
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
                                        Categorie
                                    </div>

                                </div>
                                <div class="text-gray-600 dark:text-gray-200 text-xs">
                                 <span class=".text-3xl">
                                          Confirmé</span>
                                </div>
                            </div>
                        </li>
                        <li class="flex flex-row">
                            <div class="select-none cursor-pointer flex flex-1 items-center p-3">
                                <div class="flex flex-col w-8 h-8 justify-center items-center mr-1">
                                    <div
                                        class="p-2 mr-1 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>
                                    </div>
                                </div>
                                <div class="flex-1 pl-1 mr-16">
                                    <div class="font-medium dark:text-white">
                                        Solde
                                    </div>

                                </div>
                                <div class="text-red-600 dark:text-gray-200 text-xs">
                                    {{ formatMoney(props.customers?.solde / 100) }}
                                </div>
                            </div>
                        </li>
                        <li class="flex flex-row">
                            <div class="select-none cursor-pointer flex flex-1 items-center p-3">
                                <div class="flex flex-col w-8 h-8 justify-center items-center mr-1">
                                    <div
                                        class="p-2 mr-1 text-blue-500 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
</svg>
                                    </div>
                                </div>
                                <div class="flex-1 pl-1 mr-16">
                                    <div class="font-medium dark:text-white">
                                        Créé le
                                    </div>

                                </div>
                                <div class="text-gray-600 dark:text-gray-200 text-xs">
                                    {{ props.customers?.created_at.substring(0,10) }}
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>
                        </div>

                        <div class="w-full md:w-2/3 mt-4 md:mt-0 ">
                            <JetValidationErrors class="mb-4 " />
                            <div class="border p-4 rounded bg-white">
                                <form @submit.prevent="submit">
                                    <div>
                                        <JetLabel for="name" value="Nom / Raison Social" />
                                        <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                                            required autofocus autocomplete="name" />
                                    </div>

                                    <div class="mt-4">
                                        <JetLabel for="email" value="Email" />
                                        <JetInput id="email" v-model="form.email" type="email" class="mt-1 block w-full"
                                            required />
                                    </div>

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
                                    <div class="mt-4 flex flex-row gap-4 w-full">
                                        <div class="w-full">
                                            <JetLabel for="description" value="description" />
                                            <textarea id="description" rows="3" v-model="form.description" type="text"
                                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
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


                                        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing">
                                            Mettre a jour
                                        </JetButton>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
</template>
