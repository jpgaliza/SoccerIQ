<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LeaderboardTable from '@/Components/LeaderboardTable.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    overview: {
        type: Object,
        default: () => ({
            rank: 8,
            totalScore: 7200,
            accuracy: 72,
            quizzesTaken: 5,
        }),
    },
    leaderboard: {
        type: Array,
        default: () => [
            { rank: 1, player: 'João Silva', score: 9200, time: '12:34', accuracy: 92 },
            { rank: 2, player: 'Maria Santos', score: 8950, time: '13:22', accuracy: 89 },
            { rank: 3, player: 'Carlos Oliveira', score: 8600, time: '14:15', accuracy: 86 },
            { rank: 4, player: 'Ana Costa', score: 8200, time: '15:45', accuracy: 82 },
            { rank: 5, player: 'Pedro Alves', score: 7800, time: '16:30', accuracy: 78 },
            { rank: 6, player: 'Lúcia Ferreira', score: 7500, time: '17:00', accuracy: 75 },
        ],
    },
});

const metricCards = computed(() => [
    {
        label: 'Sua posição',
        value: props.overview?.rank ? `#${props.overview.rank}` : '—',
        helper: 'Ranking global',
    },
    {
        label: 'Pontuação total',
        value: props.overview?.totalScore ? props.overview.totalScore.toLocaleString('pt-BR', { minimumFractionDigits: 0 }) : '—',
        helper: 'Pontos acumulados',
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
                    <Link :href="route('history')"
                        class="rounded-button border border-emerald-200 px-6 py-3 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-200 focus-visible:ring-offset-2">
                    Ver histórico
                    </Link>
                </div>
                <LeaderboardTable :players="props.leaderboard" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
