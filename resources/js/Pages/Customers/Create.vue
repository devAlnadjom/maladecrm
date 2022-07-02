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

defineProps({
    //customers: Object,
});


const form = useForm({
    name: '',
    email: '',
    address: '',
    country: 'Congo',
    contact: '',
    telephone: '',
    fiscal_code: 'Non-defini',
    description: '',
    solde: 0,
    active: true,
});

const submit = () => {
    form.post(route('customers.store'), {
        //onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('customers.index')">Gestion des Clients</Link> / Ajout
                </h3>
                <div class="flex flex-row justify-end">

                </div>

            </div>
            <hr class="mt-4"/>
            <div class="mt-1">
               <div class="w-full md:flex flex-column  lg:justify-between mx-auto py-5 sm:px-6 lg:px-8 lg:gap-2">
                    <div class="  lg:flex-1 ">
                        <h3 class="text-bold"> Infos Generales</h3>
                        <p class="text-sm mb-4">Mettez un commentaires si possible</p>
                    </div>
                    <div class="w-full md:w-2/3 ">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 rounded bg-white">
                            <form @submit.prevent="submit">
                                <div>
                                    <JetLabel for="name" value="Nom / Raison Social" />
                                    <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                                         autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4">
                                    <JetLabel for="email" value="Email" />
                                    <JetInput id="email" v-model="form.email" type="email" class="mt-1 block w-full"
                                        required />
                                </div>

                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <!--div class="w-full">
                                        <JetLabel for="contact" value="Contact" />
                                        <JetInput id="contact" v-model="form.contact" type="text"
                                            class="mt-1 block w-full" />
                                    </div-->


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
                                        <JetLabel for="description" value="Commentaire" />
                                        <textarea id="description" rows="3" v-model="form.description" type="text"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" ></textarea>
                                    </div>


                                    <div class="w-full">
                                         <JetLabel for="solde" value="Solde Courant" />
                                        <JetInput id="solde" v-model="form.solde" type="number" class="mt-1 block w-full" />

                                    </div>
                                </div>









                                <div class="mt-4">
                                    <JetLabel for="active">
                                        <div class="flex items-center">
                                            <JetCheckbox id="active" v-model:checked="form.active" name="active" />

                                            <div class="ml-2">
                                                Actif
                                            </div>
                                        </div>
                                    </JetLabel>
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
    </AppLayout>
</template>
