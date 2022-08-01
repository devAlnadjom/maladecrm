<script setup>
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <JetAuthenticationCard>
        <template #logo>
           <Link :href="'/'" class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">FreeCRM
                    <sup>beta</sup> </Link>
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Mot de passe perdu? Pas de problem.<br />
            Veuillez saisir votre adresse mail, nous vous enverrons un lien vous permettant de choisir un nouveau mot de passe.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <JetLabel for="email" value="Email" />
                <JetInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reinitialiser mot de passe
                </JetButton>
            </div>
        </form>
    </JetAuthenticationCard>
</template>
