<script setup>
import { ref, reactive } from 'vue';
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
import Draggable from 'vuedraggable';
import TaskCard from  '@/Components/TaskCard.vue';

const props = defineProps({
    companies: Object,
});

const columns = reactive( [{
          title: "Backlog",
          tasks: [
            {
              id: 1,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            },
            {
              id: 2,
              title: "Provide documentation on integrations",
              date: "Sep 12"
            },
            {
              id: 3,
              title: "Design shopping cart dropdown",
              date: "Sep 9",
              type: "Design"
            },
            {
              id: 4,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            },
            {
              id: 5,
              title: "Test checkout flow",
              date: "Sep 15",
              type: "QA"
            }
          ]
        },
        {
          title: "In Progress",
          tasks: [
            {
              id: 6,
              title: "Design shopping cart dropdown",
              date: "Sep 9",
              type: "Design"
            },
            {
              id: 7,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            },
            {
              id: 8,
              title: "Provide documentation on integrations",
              date: "Sep 12",
              type: "Backend"
            }
          ]
        },
        {
          title: "Review",
          tasks: [
            {
              id: 9,
              title: "Provide documentation on integrations",
              date: "Sep 12"
            },
            {
              id: 10,
              title: "Design shopping cart dropdown",
              date: "Sep 9",
              type: "Design"
            },
            {
              id: 11,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            },
            {
              id: 12,
              title: "Design shopping cart dropdown",
              date: "Sep 9",
              type: "Design"
            },
            {
              id: 13,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            }
          ]
        },
        {
          title: "Done",
          tasks: [
            {
              id: 14,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            },
            {
              id: 15,
              title: "Design shopping cart dropdown",
              date: "Sep 9",
              type: "Design"
            },
            {
              id: 16,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            }
          ]
        },
        {
          title: "Confirmed",
          tasks: [
            {
              id: 17,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            },
            {
              id: 18,
              title: "Design shopping cart dropdown",
              date: "Sep 9",
              type: "Design"
            },
            {
              id: 19,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            }
          ]
        },
        {
          title: "Confirmed2",
          tasks: [
            {
              id: 20,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            },
            {
              id: 21,
              title: "Design shopping cart dropdown",
              date: "Sep 9",
              type: "Design"
            },
            {
              id: 22,
              title: "Add discount code to checkout page",
              date: "Sep 14",
              type: "Feature Request"
            }
          ]
        }
      ]);
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
        <div class="w-full" >

        <div class="py-8 px-4 2xl:px-12">
            <div class="flex flex-row justify-between">
                <h3>
                    <Link class="text-xl" :href="route('companies.index')">Mon Entreprise</Link> / Configuration
                </h3>
                <div class="flex flex-row justify-end">

                    <Link :href="route('customers.create')"
                        class="flex items-center justify-between w-40 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Ajouter un Client
                    <span class="ml-2" aria-hidden="true">+</span>
                    </Link>
                </div>

            </div>
            <div class="mt-5">
                <AlertBox :flash="$page.props.flash" :on="true" class="mr-3">

                </AlertBox>
                <div class="max-w-full">

                    <div class=" mx-auto w-full .bg-black  overflow-x-auto max-w-full lg:max-w-[980px] xl:max-w-[1180px] 2xl:max-w-[1480px] 2xl:px-6">
                        <div class="min-h-screen flex py-10 ">
                            <div v-for="column in columns" :key="column.title"
                                class="bg-gray-200 px-3 py-3 min-w-[220px] lg:min-w-[280px] lg:max-w-80 xl:max-w-[300px] 2xl:max-w-[320px] rounded mr-4">
                                <p class="text-gray-700 font-semibold font-sans tracking-wide text-sm">{{ column.title }}
                                </p>
                                <!-- Draggable component comes from vuedraggable. It provides drag & drop functionality -->
                                <Draggable v-model="column.tasks"  @start="drag=true" @end="drag=true"  item-key="id" :animation="200" ghost-class="ghost-card" group="tasks" tag="ul">
                                          <template #item="{element}">

                                            <TaskCard  :task="element"
                                                class="mt-3 cursor-move"></TaskCard>
                                        </template>
                                </Draggable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AppLayout>
</template>

<style scoped>
.column-width {
  min-width: 300px;
  width: 300px;
}
/* Unfortunately @apply cannot be setup in codesandbox,
but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
.ghost-card {
  opacity: 0.5;
  background: #F7FAFC;
  border: 1px solid #4299e1;
}
</style>
