<script setup>
import { ref } from 'vue';

const props = defineProps({
    comments: Object,
});

</script>

<template>

        <ol class="relative border-l border-gray-200 dark:border-gray-700">
            <template v-for="comment in comments" :key="comment.id">
                <li class="mb-5 ml-2">
                    <div
                        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                        {{ comment.created_at }}
                    </time>
                    <h3 class="text-sm font-semibold  text-gray-900 dark:text-white">
                        {{ comment.type }}
                    </h3>
                    <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">
                        {{ comment.comment }}
                    </p>

                </li>
            </template>

        </ol>

</template>
