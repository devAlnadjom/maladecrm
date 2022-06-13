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

const props= defineProps({
    customers: Object,
});


const form = useForm({
    customer_id:null,
    order_id:'0',
    description: '',
    method: '',
    montant: 0,
    date:null,
});

const submit = () => {
    form.post(route('payments.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-8 px-3">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('payments.index')">Payments Management</Link> / Add New
                </h3>


            </div>
            <div class="mt-5">
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="">
                        <JetValidationErrors class="mb-4 " />
                        <div class="border p-4 rounded-sm">
                            <form @submit.prevent="submit">
                                <div>
                                    <JetLabel for="name" value="Customer" />

                                    <select class="mt-1 block w-full bg-gray-100 border-0 rounded" v-model="form.customer_id" @change="selectedCustomer()">
                                        <option :value="null"> Select Customer</option>
                                        <template v-for="(item, index) in customers" :key="index">
                                            <option :value="item.id"> {{item.name}} -- Solde:{{item.solde}} </option>
                                        </template>
                                    </select>
                                </div>

                                <!--div class="mt-4">
                                    <JetLabel for="email" value="Email" />
                                    <JetInput id="email" v-model="form.email" type="email" class="mt-1 block w-full"
                                        required />
                                </div-->

                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="date" value="Date" />
                                        <JetInput id="date" v-model="form.date" type="date"
                                            class="mt-1 block w-full" />
                                    </div>


                                    <div class="w-full">
                                        <JetLabel for="Method" value="Method" />
                                        <JetInput id="Method" v-model="form.method" type="text"
                                            class="mt-1 block w-full" placehoder="Ex:Bank Transfer" />
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-row gap-4 w-full">
                                    <div class="w-full">
                                        <JetLabel for="description" value="description" />
                                        <textarea id="description" rows="3" v-model="form.description" type="text"
                                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" ></textarea>
                                    </div>


                                    <div class="w-full">
                                         <JetLabel for="solde" value="Amount to Pay" />
                                        <JetInput id="solde" v-model="form.montant" type="number" class="mt-1 block w-full" />

                                    </div>
                                </div>



                                <div class="flex items-center justify-end mt-4">
                                    <button type="reset" class="underline text-sm text-gray-600 hover:text-gray-900">
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
