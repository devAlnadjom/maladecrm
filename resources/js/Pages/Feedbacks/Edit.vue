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
</script>

<template>
    <AppLayout title="Customer Management">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('customers.index')">Custommers Management</Link> / Update Customer
                </h3>
                <div class="flex flex-row justify-end">
                    <Link :href="route('customers.create')"
                        class="flex items-center mx-2 justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Payment
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
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
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 rounded-sm">
                            <form @submit.prevent="submit">
                                <div>
                                    <JetLabel for="name" value="Name" />
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
