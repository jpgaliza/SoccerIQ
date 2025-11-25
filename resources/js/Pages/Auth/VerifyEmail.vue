<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>

        <Head title="Verificação de e-mail" />

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Obrigado por se cadastrar! Antes de começar, confirme seu e-mail
            clicando no link que acabamos de enviar. Caso não tenha recebido,
            podemos enviar outro.
        </div>

        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400" v-if="verificationLinkSent">
            Um novo link de verificação foi enviado para o e-mail informado no
            cadastro.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reenviar e-mail de verificação
                </PrimaryButton>

                <Link :href="route('logout')" method="post" as="button"
                    class="rounded-md text-sm text-gray-600 underline hover:text-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2">
                Sair</Link>
            </div>
        </form>
    </GuestLayout>
</template>
