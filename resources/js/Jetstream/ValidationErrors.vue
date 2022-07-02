<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const errors = computed(() => usePage().props.value.errors);
const hasErrors = computed(() => Object.keys(errors.value).length > 0);

const _trans=(message)=>{
    var map = new Map();
    map.set('auth.failed', 'Impossible de se connecter. La combinaison saisie n\'est pas valide.');

    if(map.has(message)){
        return map.get(message);
    }
    return message;
}
</script>

<template>
    <div v-if="hasErrors" class="px-2 py-3 bg-red-100 border-l-2 border-l-red-800 ">
        <div class="font-medium text-red-600">
           Oops! Une erreur est survenue.
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in errors" :key="key">
                {{ _trans(error) }}
            </li>
        </ul>
    </div>
</template>
