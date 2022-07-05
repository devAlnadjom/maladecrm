<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

const props = defineProps({
    customers: Object,
    customer_id: Object,
});


const form = useForm({
    customer_id: props.customer_id,
    order_id: '0',
    description: '',
    method: '',
    montant: 0,
    date: null,
});

const submit = () => {
    form.post(route('payments.store'), {
        //onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Ajouter un Paiement">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('payments.index')">Gestion des Paiements</Link> / Ajouter
                </h3>


            </div>
            <hr class="mt-4" />
            <div class="mt-1">
                <div class="w-full md:flex flex-column  lg:justify-between mx-auto py-5 sm:px-6 lg:px-8 lg:gap-2">
                    <div class="  lg:flex-1 ">
                        <h3 class="text-bold"> Ajouter un paiemnt</h3>
                        <p class="text-sm mb-4">Mettez un commentaire si possible</p>
                    </div>
                    <div class="md:w-2/3">
                        <div class="">
                            <JetValidationErrors class="mb-4 " />
                            <div class="border bg-white p-4 rounded-md">
                                <form @submit.prevent="submit">
                                    <div>
                                        <JetLabel for="name" value="Client" />

                                        <select class="mt-1 block w-full bg-gray-100 border-0 rounded"
                                            v-model="form.customer_id" @change="selectedCustomer()">
                                            <option :value="null"> Selectioner un Client</option>
                                            <template v-for="(item, index) in customers" :key="index">
                                                <option :value="item.id"> {{ item.name }} -- Solde:{{parseInt(item.solde)/100 }}
                                                </option>
                                            </template>
                                        </select>
                                    </div>


                                    <div class="mt-4 flex flex-row gap-4 w-full">
                                        <div class="w-full">
                                            <JetLabel for="date" value="Date de Paiement" />
                                            <JetInput id="date" v-model="form.date" type="date"
                                                class="mt-1 block w-full" />
                                        </div>


                                        <div class="w-full">
                                            <JetLabel for="Method" value="Methode de Paiment" />
                                                <select
                                                    class="text-gray-700 mt-1 block appearance-none w-full bg-gray-200 border-2 border-gray-200 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                                    v-model="form.method">
                                                    <option value="">Select. une Methode</option>
                                                    <option value="ESPECES">ESPECES</option>
                                                    <option value="VIREMENT BANACAIRE">VIREMENT BANACAIRE</option>
                                                    <option value="PAIEMENT MOBILE">PAIEMENT MOBILE</option>
                                                    <option value="Autres">Autres</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex flex-row gap-4 w-full">
                                        <div class="w-full">
                                            <JetLabel for="description" value="Detail" />
                                            <textarea id="description" rows="3" v-model="form.description" type="text"
                                                placeholder="Les details peuvent vous aider. Pemsez a y mettre"
                                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
                                        </div>


                                        <div class="w-full">
                                            <JetLabel for="solde" value="Montant payé" />
                                            <JetInput id="solde" v-model="form.montant" type="number"
                                                class="mt-1 block w-full" />

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
            </div>
        </div>
    </AppLayout>
</template>
