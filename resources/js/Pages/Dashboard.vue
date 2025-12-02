<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LeaderboardTable from '@/Components/LeaderboardTable.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    overview: {
        type: Object,
        default: () => ({
            rank: null,
            bestScore: 0,
            accuracy: 0,
            quizzesTaken: 0,
        }),
    },
    leaderboard: {
        type: Array,
        default: () => [],
    },
});

const metricCards = computed(() => [
    {
        label: 'Sua posição',
        value: props.overview?.rank ? `#${props.overview.rank}` : '—',
        helper: 'Ranking global',
    },
    {
        label: 'Melhor pontuação',
        value: props.overview?.bestScore ? props.overview.bestScore.toLocaleString('pt-BR', { minimumFractionDigits: 0 }) : '—',
        helper: 'Maior pontuação obtida',
    },
    {
        label: 'Precisão',
        value: props.overview?.accuracy ? `${props.overview.accuracy}%` : '—',
        helper: 'Taxa de acertos',
    },
    {
        label: 'Quizzes jogados',
        value: props.overview?.quizzesTaken ?? '—',
        helper: 'Partidas concluídas',
    },
]);
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="bg-gradient-to-b from-neutral-50 via-white to-white py-10">
            <div class="mx-auto max-w-6xl space-y-10 px-4 sm:px-6 lg:px-0">
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <article v-for="card in metricCards" :key="card.label"
                        class="rounded-2xl border border-emerald-50 bg-white/95 p-6 shadow-lg shadow-emerald-50">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">
                            {{ card.label }}
                        </p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">
                            {{ card.value }}
                        </p>
                        <p class="mt-2 text-sm text-slate-500">{{ card.helper }}</p>
                    </article>
                </div>

                <div class="flex flex-wrap gap-4">
                    <Link :href="route('quiz')"
                        class="rounded-button bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2">
                    Iniciar novo quiz
                    </Link>
                    <!-- <Link :href="route('history')"
                        class="rounded-button border border-emerald-200 px-6 py-3 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-200 focus-visible:ring-offset-2">
                    Ver histórico
                    </Link> -->
                </div>
                <LeaderboardTable :players="props.leaderboard" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
