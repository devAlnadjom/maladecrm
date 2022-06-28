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

import AlertBox from '@/Jetstream/AlertBox.vue';

defineProps({
    //customers: Object,
});


const form = useForm({
    name: '',
    categorie: '',
    address: '',
    contact: '',
    description: '',
    active: 1,
});

const submit = () => {
    form.post(route('companies.store'), {
        onFinish: () => {},
    });
};
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('companies.show',1)">Votre Entreprise</Link> / Configuration
                </h3>
            </div>

            <div class="mt-5">
                <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8">
                    <AlertBox :flash="$page.props.flash" :on="true" class="mr-3 mb-4"></AlertBox>

                    <div class="">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 rounded-md bg-white">
                            <form @submit.prevent="submit">
                                <div>
                                    <JetLabel for="name" value="Nom / Raison Social" />
                                    <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                                        required autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4">
                                    <JetLabel for="categorie" value="Domaine de Specialisation" />
                                    <JetInput id="categorie" v-model="form.categorie" type="text"
                                        class="mt-1 block w-full" required />
                                </div>

                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="contact" value="Contact" />
                                        <JetInput id="contact" v-model="form.contact" type="text"
                                            class="mt-1 block w-full"  required/>
                                    </div>

                                    <div class="w-full">
                                        <JetLabel for="address" value="Addresse" />
                                        <JetInput id="address" v-model="form.address" type="text"
                                            class="mt-1 block w-full"  required/>
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
