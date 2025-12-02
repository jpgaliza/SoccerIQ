<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-700 transition duration-150 ease-in-out hover:bg-emerald-50 focus:bg-emerald-50 focus:outline-none first:rounded-t-2xl last:rounded-b-2xl">
    <slot />
    </Link>
</template>
