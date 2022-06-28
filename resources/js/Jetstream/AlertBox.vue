<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props =defineProps({
    flash: Object,
    on: Boolean,
});
let open = ref(true);


onMounted(() => {
    open.value = props.on;
    setTimeout(() => {open.value = false}, 3500)
});
</script>

<template>
    <div>
        <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
           <div>
                <div v-show="flash.success && open" class="text-sm text-gray-600">
                    <div class="py-3 px-3  w-full rounded bg-green-700 text-white">
                            <span> {{ flash.success }}</span>
                        </div>
                </div>
                <div v-show="flash.error && open" class="text-sm text-gray-600">
                    <div class="py-3 px-3  w-full rounded bg-red-600 text-white">
                            <span> {{ flash.error }}</span>
                        </div>
                </div>
           </div>

        </transition>
    </div>
</template>
