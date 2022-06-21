<script setup>
import { ref, reactive, nextTick } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetDialogModal from '@/Jetstream//DialogModal.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';


const props = defineProps({
    company: Object,
   customer_count: Object,
   invoice_waiting: Object,
   invoice_completed: Object,
   solde: Object,
   lastproducts: Object,
});

const  formatMoney=(number) =>{
   return 'XAF '+ parseInt(number).toLocaleString('en-US');
};
//console.log(props.customer_count)


const modalOpen = ref(false);

const form = reactive({
    password: '',
    error: '',
    processing: false,
});

const _form = useForm({
    type:'',
    comment: '',
    processing: false,
});

const submitFeedBack = () => {
    _form.processing=true;
    _form.post(route('feedbacks.store'), {
        preserveScroll: true,
        onSuccess: () => {_form.reset(); closeModal();},
        onFinish: () => { _form.processing=false;},
    });
};

const passwordInput = ref(null);

const startConfirmingPassword = () => {
    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');
        } else {
            modalOpen.value = true;

            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;

        closeModal();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        passwordInput.value.focus();
    });
};

const showModal=() => {
    modalOpen.value = true;
}

const closeModal = () => {
    modalOpen.value = false;
    form.password = '';
    form.error = '';
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex md:flex-row justify-between">
                 <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Bienvenue
                 </h2>
                 <span @click="showModal()"
                        class=" cursor-pointer flex items-center mx-2 justify-between w-58 px-4 py-2 text-sm font-medium leading-5 text-purple-600  hover:text-white transition-colors duration-150 border border-purple-600 rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Aidez nous a ammeliorer.
                    <span class="ml-2" aria-hidden="true">+</span>
                </span>
            </div>

        </template>

        <div class="py-12">
            <div class="max -w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="company==null" class=" bg-red-500 rounded-md border px-10 py-4 my-5 w-full">
                    <h3 class=" text-white"> You have to set your company setting</h3>
                    <Link :href="route('companies.create')">
                        <div class="mt-1 flex items-center text-sm font-semibold text-gray-100 hover:text-white">
                            <div>Set Up my Company</div>

                            <div class="ml-1 ">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </Link>
                </div>

                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total clients
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{props.customer_count.data}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Amount due
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{formatMoney( props.solde.data)}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    New sales
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{props.invoice_completed.data_count}} | {{formatMoney(props.invoice_completed.data_sum) }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Pending Invoice
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{props.invoice_waiting.data}}
                  </p>
                </div>
              </div>
            </div>

                <div class="my-5">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:w-2/3">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                   Ref
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Montant
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in lastproducts" :key="order.id" class="bg-white dark:bg-gray-800 hover:bg-gray-100 border-t">
                                <th scope="row"
                                    class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    ORD- {{ order.id }}
                                    <p class="font-light">{{ order?.nom }} </p>

                                </th>
                                <td class="px-6 py-2">
                                    <p class=" font-bold">{{ order?.total_quantity }} X {{ order?.name }} </p>

                                </td>

                                <td class="px-6 py-2">

                                    {{ formatMoney(order?.total_price)}}
                                </td>
                                <td class="px-6 py-2 text-right">
                                     <a :href="'invoices/'+order.order_key+'/'+order.id" target="_blank"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline px-2">Invoice</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                </div>

            </div>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <!--Welcome /-->
                </div>


        <JetDialogModal :show="modalOpen" @close="closeModal">
            <template #title>
               Laissez nous un commentaire
            </template>

            <template #content>

                <JetValidationErrors class="mt-4 " />
                <div class="mt-4">
                     <select class="w-3/4 text-gray-800 block font-bold  mt-1  border-1 rounded" v-model="_form.type" >
                        <option :value="null"> Select Option</option>
                        <option :value="'Suggestion'"> Suggestion</option>
                        <option :value="'Erreur / Beug'"> Erreur / Beug</option>
                        <option :value="'Autres'"> Autres </option>
                    </select>

                </div>
                <div class="mt-4">
                    <textarea id="description" rows="3" v-model="_form.comment"
                                placeholder="Laissez votre commentaire"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"></textarea>


                </div>
            </template>

            <template #footer>
                <JetSecondaryButton @click="closeModal">
                    Cancel
                </JetSecondaryButton>

                <JetButton
                    class="ml-3"
                    :class="{ 'opacity-25': _form.processing }"
                    :disabled="_form.processing"
                    @click="submitFeedBack"
                >
                    Envoyer
                </JetButton>
            </template>
        </JetDialogModal>

            </div>
        </div>
    </AppLayout>
</template>
