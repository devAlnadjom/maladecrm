<script setup>
import { ref } from 'vue';

const props = defineProps({
    status: Object,
});

</script>

<template>
    <div>
        <span v-if="status == 1"
            class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-green-700 dark:text-green-100">
            A Confirmer
        </span>
        <span v-if="status == 2"
            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
            Validée
        </span>
        <span v-if="status == 3"
            class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-green-700 dark:text-green-100">
            Payée
        </span>
        <span v-if="status == 4"
            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
            Annullée
        </span>
    </div>
</template>
