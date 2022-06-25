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
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';

const props = defineProps({
    companies: Object,
});


const form = useForm({
    _method: "PUT",
    name: props.companies?.name,
    categorie: props.companies?.categorie,
    address: props.companies?.address,
    contact: props.companies?.contact,
    description: props.companies?.description,
    active: props.companies?.active,
});

const submit = () => {
    form.post(route('companies.update', props.companies.id), {
        //onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Customer Management">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('companies.index')">Company Management</Link> / Update Customer
                </h3>
                <div class="flex flex-row justify-end">

                    <Link :href="route('customers.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Create Customer
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <AlertBox :flash="$page.props.flash" :on="true" class="mr-3">

                </AlertBox>
                <div class="w-full flex justify-between mx-auto py-5 sm:px-6 lg:px-8 gap-2">
                    <div class="flex-1">
                        <h3 class="text-bold"> General Infos</h3>
                        <p class="text-sm">Your company identifications informations, This will appear in invoices</p>
                    </div>
                    <div class="lg:w-2/3 bg-white">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 rounded">
                             <form @submit.prevent="submit">
                                <div>
                                    <JetLabel for="name" value="Name" />
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
                                            class="mt-1 block w-full" />
                                    </div>

                                    <div class="w-full">
                                        <JetLabel for="address" value="address" />
                                        <JetInput id="address" v-model="form.address" type="text"
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


                                <div class="flex items-center justify-end mt-4 ">
                                    <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Update
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
