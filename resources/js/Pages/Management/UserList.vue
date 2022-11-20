<script setup>
import { ref,onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import AlertBox from '@/Jetstream/AlertBox.vue';
import Pagination from '../../Jetstream/Pagination.vue';
import Helper from '@/helper.js'
const props= defineProps({
    users: Object,
});


const showAlert =ref(true);

onMounted(() =>{
    setTimeout(() =>{ showAlert.value=false;},3500);
})
</script>

<template>
    <AppLayout title="Custommers Management">


        <div class="py-8 xl:px-10 px-3">
            <div class="flex flex-row justify-between">
                <h3 class="text-xl">List des Utilisateurs</h3>
                <div class="flex flex-row justify-end">


                </div>

            </div>
            <div class="mt-5" >
                <AlertBox v-if="showAlert" :flash="$page.props.flash" :on="showAlert" class="mb-3"></AlertBox>

                <div class="bg-white overflow-auto shadow-xl sm:rounded-lg">

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                   Ref
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Company
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="props.users">
                            <tr v-for="user in users.data" :key="user.id" class="bg-white dark:bg-gray-800 hover:bg-gray-100 buser-t">
                                <th scope="row"
                                    class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    # -{{ user.id }}
                                    {{ Helper.formatMoney(1000) }}
                                </th>
                                <td class="px-6 py-2">
                                    <p class=" font-bold">{{ user.name }} </p>
                                    <span class="text-sm hover:text-indigo-500 cursor-pointer">{{ user.email }} </span>
                                </td>
                                <td class="px-6 py-2">
                                    {{ user?.company?.name }}
                                </td>
                                <td class="px-6 py-2">
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        Actif
                                    </span>
                                </td>
                                <td class="px-6 py-2 text-right">
                                    <div class="md:flex md:items-end">
                                        View
                                    <!--Link :href="route('dashboard.show')"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Détails</Link -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                </div>
                <div  class="mt-3 flex flex-row-reverse ">
                    <Pagination :links="users.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
