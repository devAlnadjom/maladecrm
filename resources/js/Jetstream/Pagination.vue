<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
defineProps({
    links: Array
});
const _trans=(message)=>{
    var map = new Map();
    map.set('pagination.previous', 'Precedent');
    map.set('pagination.next', 'Suivant');

    if(map.has(message)){
        return map.get(message);
    }
    return message;
}
</script>


<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="_trans(link.label)" />
                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500 hover:text-indigo-500"
                    :class="{ 'bg-blue-700 text-white': link.active }" :href="link.url" v-html="_trans(link.label)" />
            </template>
        </div>
    </div>
</template>

<!--script>
    export default {
        props: {

        },
    }
</script-->
