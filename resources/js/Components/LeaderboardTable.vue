<script setup>
import { computed, ref, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    players: {
        type: Array,
        default: () => [],
    },
    perPage: {
        type: Number,
        default: 10,
    },
});

const currentPage = ref(1);
const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth < 640; // sm breakpoint
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

const pageSize = computed(() => {
    const size = isMobile.value ? 5 : (props.perPage || 10);
    return Math.min(size, 10);
});

const totalPages = computed(() => {
    if (!props.players.length) return 1;
    return Math.ceil(props.players.length / pageSize.value);
});

watch(
    () => props.players.length,
    () => {
        currentPage.value = 1;
    },
);

const paginatedPlayers = computed(() => {
    const start = (currentPage.value - 1) * pageSize.value;
    return props.players.slice(start, start + pageSize.value);
});

const summary = computed(() => {
    if (!props.players.length) {
        return { start: 0, end: 0, total: 0 };
    }
    const start = (currentPage.value - 1) * pageSize.value + 1;
    const end = Math.min(start + pageSize.value - 1, props.players.length);
    return { start, end, total: props.players.length };
});

const goToPage = (direction) => {
    if (direction === 'prev' && currentPage.value > 1) {
        currentPage.value -= 1;
    }
    if (direction === 'next' && currentPage.value < totalPages.value) {
        currentPage.value += 1;
    }
};

const buttonBaseClass =
    'rounded-button border px-4 py-2 text-sm font-semibold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-200 focus-visible:ring-offset-2';

const prevButtonClass = computed(() =>
    [
        buttonBaseClass,
        currentPage.value === 1
            ? 'border-slate-200 bg-white/80 text-slate-400'
            : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50',
    ].join(' '),
);

const nextButtonClass = computed(() =>
    [
        buttonBaseClass,
        currentPage.value === totalPages.value
            ? 'border-slate-200 bg-white/80 text-slate-400'
            : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50',
    ].join(' '),
);
</script>

<template>
    <section class="rounded-3xl border border-slate-100 bg-white/95 p-6 shadow-xl">
        <header class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-medal-icon lucide-medal">
                        <path
                            d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15" />
                        <path d="M11 12 5.12 2.2" />
                        <path d="m13 12 5.88-9.8" />
                        <path d="M8 7h8" />
                        <circle cx="12" cy="17" r="5" />
                        <path d="M12 18v-2h-.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">
                        Global Ranking
                    </p>
                    <p class="text-xl font-bold text-slate-900">Top players performance</p>
                </div>
            </div>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left text-sm text-slate-600">
                <thead class="text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="pb-3 font-semibold">Position</th>
                        <th class="pb-3 font-semibold">Player</th>
                        <th class="pb-3 font-semibold">Score</th>
                        <th class="pb-3 font-semibold">Time</th>
                        <th class="pb-3 font-semibold">Accuracy</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-base text-slate-800">
                    <tr v-for="player in paginatedPlayers" :key="player.rank" class="hover:bg-emerald-50/30">
                        <td class="py-4 font-semibold text-emerald-600">#{{ player.rank }}</td>
                        <td class="py-4">{{ player.player }}</td>
                        <td class="py-4 font-semibold">{{ player.score.toLocaleString('en-US') }}</td>
                        <td class="py-4 text-slate-500">{{ player.time }}</td>
                        <td class="py-4 text-slate-500">{{ player.accuracy }}%</td>
                    </tr>
                    <tr v-if="!paginatedPlayers.length">
                        <td class="py-6 text-center text-slate-400" colspan="5">No players found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex flex-col gap-3 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p v-if="summary.total">Showing {{ summary.start }}-{{ summary.end }} of {{ summary.total }} players</p>
            <p v-else>No results to display.</p>
            <div class="flex items-center gap-2">
                <button type="button" :class="prevButtonClass" @click="goToPage('prev')" :disabled="currentPage === 1">
                    Previous
                </button>
                <span class="px-2 text-slate-500">Page {{ currentPage }} of {{ totalPages }}</span>
                <button type="button" :class="nextButtonClass" @click="goToPage('next')"
                    :disabled="currentPage === totalPages">
                    Next
                </button>
            </div>
        </div>
    </section>
</template>
