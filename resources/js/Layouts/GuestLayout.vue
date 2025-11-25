<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen items-center justify-center bg-gradient-to-b from-white via-emerald-50 to-white px-4 py-10">
        <div class="w-full max-w-md space-y-8">
            <div class="flex justify-center">
                <Link href="/">
                <ApplicationLogo class="text-slate-900" />
                </Link>
            </div>

            <div class="rounded-2xl bg-white/95 px-8 py-8 shadow-2xl ring-1 ring-emerald-100">
                <slot />
            </div>

            <p class="text-center text-sm text-slate-500">Acesso seguro ao SoccerIQ</p>
        </div>
    </div>
</template>
