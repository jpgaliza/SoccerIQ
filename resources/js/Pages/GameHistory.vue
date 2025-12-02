<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    entries: {
        type: Array,
        default: () => [
            { id: 1, quizName: 'Quiz SoccerIQ #21', score: 720, duration: '08:12', date: '15 Nov', result: 'Excelente' },
            { id: 2, quizName: 'Quiz SoccerIQ #20', score: 680, duration: '09:05', date: '12 Nov', result: 'Muito bom' },
            { id: 3, quizName: 'Quiz SoccerIQ #19', score: 640, duration: '07:55', date: '10 Nov', result: 'Bom' },
            { id: 4, quizName: 'Quiz SoccerIQ #18', score: 700, duration: '08:40', date: '08 Nov', result: 'Excelente' },
            { id: 5, quizName: 'Quiz SoccerIQ #17', score: 615, duration: '09:58', date: '05 Nov', result: 'Bom' },
        ],
    },
});

const totalQuizzes = computed(() => props.entries.length);
const averageScore = computed(() => {
    if (!props.entries.length) return 0;
    const sum = props.entries.reduce((acc, entry) => acc + entry.score, 0);
    return Math.round(sum / props.entries.length);
});

const bestTime = computed(() => {
    if (!props.entries.length) return '—';
    const minutes = props.entries
        .map((entry) => {
            const [min, sec] = entry.duration.split(':').map(Number);
            return min * 60 + sec;
        })
        .sort((a, b) => a - b)[0];
    const bestMinutes = String(Math.floor(minutes / 60)).padStart(2, '0');
    const bestSeconds = String(minutes % 60).padStart(2, '0');
    return `${bestMinutes}:${bestSeconds}`;
});
</script>

<template>

    <Head title="Histórico" />

    <AuthenticatedLayout>
        <div class="bg-gradient-to-b from-neutral-50 via-white to-white py-10">
            <div class="mx-auto max-w-6xl space-y-8 px-4 sm:px-6 lg:px-0">
                <header class="space-y-2">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Histórico</p>
                    <h1 class="text-3xl font-bold text-slate-900">Quizzes já jogados</h1>
                    <p class="text-sm text-slate-500">Revise seus resultados anteriores e acompanhe sua evolução.</p>
                </header>

                <div class="grid gap-4 md:grid-cols-3">
                    <article class="rounded-2xl border border-emerald-50 bg-white/95 p-5 shadow">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Quizzes concluídos</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ totalQuizzes }}</p>
                        <p class="mt-1 text-sm text-slate-500">Total de tentativas registradas</p>
                    </article>
                    <article class="rounded-2xl border border-emerald-50 bg-white/95 p-5 shadow">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Pontuação média</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ averageScore }} pts</p>
                        <p class="mt-1 text-sm text-slate-500">Baseado nos últimos quizzes</p>
                    </article>
                    <article class="rounded-2xl border border-emerald-50 bg-white/95 p-5 shadow">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Melhor tempo</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ bestTime }}</p>
                        <p class="mt-1 text-sm text-slate-500">Tempo mais rápido para finalizar</p>
                    </article>
                </div>

                <section class="rounded-3xl border border-slate-100 bg-white/95 p-6 shadow-xl">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Linha do tempo</p>
                            <h2 class="text-xl font-bold text-slate-900">Resultados recentes</h2>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600">
                            Atualizado automaticamente
                        </span>
                    </div>
                    <div class="space-y-4">
                        <article v-for="entry in props.entries" :key="entry.id"
                            class="rounded-2xl border border-slate-100 px-4 py-4 shadow-sm transition hover:border-emerald-100 hover:shadow-md">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-emerald-600">{{ entry.date }}</p>
                                    <h3 class="text-lg font-bold text-slate-900">{{ entry.quizName }}</h3>
                                </div>
                                <div class="flex flex-wrap gap-4 text-sm font-semibold text-slate-600">
                                    <div class="rounded-xl bg-slate-50 px-4 py-2 text-center">
                                        <p class="text-xs uppercase tracking-wide text-slate-400">Pontuação</p>
                                        <p class="text-base font-bold text-slate-900">{{ entry.score }} pts</p>
                                    </div>
                                    <div class="rounded-xl bg-slate-50 px-4 py-2 text-center">
                                        <p class="text-xs uppercase tracking-wide text-slate-400">Tempo</p>
                                        <p class="text-base font-bold text-slate-900">{{ entry.duration }}</p>
                                    </div>
                                    <div class="rounded-xl bg-emerald-50 px-4 py-2 text-center text-emerald-700">
                                        <p class="text-xs uppercase tracking-wide">Resultado</p>
                                        <p class="text-base font-bold">{{ entry.result }}</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <p v-if="!props.entries.length" class="text-center text-sm text-slate-400">
                            Você ainda não completou nenhum quiz. Jogue o primeiro para ver seu histórico aqui!
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
