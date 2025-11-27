<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const quizMeta = {
    code: 'Quiz SoccerIQ #27',
    reward: 200,
    timeLimit: '10 minutos',
    totalQuestions: 4,
    info: ['10 perguntas rápidas', '4 alternativas por pergunta', '1 resposta correta'],
};

const questions = [
    {
        id: 1,
        code: 'Quiz SoccerIQ #27',
        question: 'Quem marcou os dois gols do Brasil na final da Copa do Mundo de 2002?',
        options: [
            { id: 'a', label: 'A', text: 'Rivaldo' },
            { id: 'b', label: 'B', text: 'Ronaldo Fenômeno' },
            { id: 'c', label: 'C', text: 'Ronaldinho Gaúcho' },
            { id: 'd', label: 'D', text: 'Kaká' },
        ],
        correct: 'b',
        points: 50,
    },
    {
        id: 2,
        code: 'Quiz SoccerIQ #27',
        question: 'Qual clube revelou Neymar antes da sua ida ao Barcelona?',
        options: [
            { id: 'a', label: 'A', text: 'Santos' },
            { id: 'b', label: 'B', text: 'Flamengo' },
            { id: 'c', label: 'C', text: 'Palmeiras' },
            { id: 'd', label: 'D', text: 'São Paulo' },
        ],
        correct: 'a',
        points: 50,
    },
    {
        id: 3,
        code: 'Quiz SoccerIQ #27',
        question: 'Em que país aconteceu a Copa do Mundo que revelou James Rodríguez em 2014?',
        options: [
            { id: 'a', label: 'A', text: 'África do Sul' },
            { id: 'b', label: 'B', text: 'Alemanha' },
            { id: 'c', label: 'C', text: 'Brasil' },
            { id: 'd', label: 'D', text: 'Rússia' },
        ],
        correct: 'c',
        points: 50,
    },
    {
        id: 4,
        code: 'Quiz SoccerIQ #27',
        question: 'Qual seleção venceu a Eurocopa de 2016 com gol de Éder na final?',
        options: [
            { id: 'a', label: 'A', text: 'França' },
            { id: 'b', label: 'B', text: 'Espanha' },
            { id: 'c', label: 'C', text: 'Itália' },
            { id: 'd', label: 'D', text: 'Portugal' },
        ],
        correct: 'd',
        points: 50,
    },
];

const showIntroModal = ref(true);
const showSummaryModal = ref(false);
const currentQuestionIndex = ref(0);
const selectedOption = ref(null);
const isAnswerRevealed = ref(false);
const score = ref(0);
const feedbackMessage = ref('');
const feedbackType = ref('neutral');

const totalQuestions = questions.length;
quizMeta.totalQuestions = totalQuestions;

const currentQuestion = computed(() => questions[currentQuestionIndex.value]);

const progressPercent = computed(() => {
    const completed = currentQuestionIndex.value + (isAnswerRevealed.value ? 1 : 0);
    return Math.round((completed / totalQuestions) * 100);
});

const actionButtonLabel = computed(() => {
    if (!isAnswerRevealed.value) {
        return 'Confirmar resposta';
    }
    return currentQuestionIndex.value === totalQuestions - 1
        ? 'Finalizar quiz'
        : 'Próxima pergunta';
});

const actionButtonDisabled = computed(() => !isAnswerRevealed.value && !selectedOption.value);

const actionButtonClasses = computed(() => {
    if (actionButtonDisabled.value) {
        return 'rounded-button w-full bg-slate-200 px-6 py-3 text-center text-base font-semibold text-slate-500 cursor-not-allowed';
    }
    return 'rounded-button w-full bg-emerald-500 px-6 py-3 text-center text-base font-semibold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2';
});

const selectOption = (optionId) => {
    if (isAnswerRevealed.value) return;
    selectedOption.value = optionId;
};

const startQuiz = () => {
    showIntroModal.value = false;
};

const handlePrimaryAction = () => {
    if (!isAnswerRevealed.value) {
        if (!selectedOption.value) return;
        isAnswerRevealed.value = true;
        const isCorrect = selectedOption.value === currentQuestion.value.correct;
        if (isCorrect) {
            score.value += currentQuestion.value.points;
            feedbackMessage.value = `Resposta correta! +${currentQuestion.value.points} pts.`;
            feedbackType.value = 'correct';
        } else {
            feedbackMessage.value = 'Resposta incorreta. Continue focado!';
            feedbackType.value = 'incorrect';
        }
        return;
    }

    if (currentQuestionIndex.value === totalQuestions - 1) {
        showSummaryModal.value = true;
        return;
    }

    currentQuestionIndex.value += 1;
    selectedOption.value = null;
    isAnswerRevealed.value = false;
    feedbackMessage.value = '';
    feedbackType.value = 'neutral';
};

const optionClasses = (optionId) => {
    const base = 'flex w-full items-center justify-between rounded-2xl border px-5 py-4 text-left text-base font-semibold transition shadow-sm';
    if (isAnswerRevealed.value) {
        if (optionId === currentQuestion.value.correct) {
            return `${base} border-emerald-400 bg-emerald-50 text-emerald-700`;
        }
        if (optionId === selectedOption.value && optionId !== currentQuestion.value.correct) {
            return `${base} border-rose-300 bg-rose-50 text-rose-600`;
        }
        return `${base} border-slate-100 bg-white text-slate-500`;
    }
    if (selectedOption.value === optionId) {
        return `${base} border-emerald-400 bg-emerald-50 text-emerald-700`;
    }
    return `${base} border-slate-200 bg-white text-slate-700 hover:border-emerald-200`;
};

const optionBadgeClasses = (optionId) => {
    const base = 'mr-3 flex h-10 w-10 items-center justify-center rounded-2xl text-base font-bold';
    if (isAnswerRevealed.value && optionId === currentQuestion.value.correct) {
        return `${base} bg-emerald-500 text-white`;
    }
    if (isAnswerRevealed.value && optionId === selectedOption.value && optionId !== currentQuestion.value.correct) {
        return `${base} bg-rose-500 text-white`;
    }
    if (selectedOption.value === optionId) {
        return `${base} bg-emerald-500 text-white`;
    }
    return `${base} bg-slate-100 text-slate-600`;
};

const returnToDashboard = () => {
    showSummaryModal.value = false;
    router.visit(route('dashboard'));
};
</script>

<template>

    <Head title="Quiz" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-gradient-to-b from-neutral-50 via-white to-white py-12">
            <div class="mx-auto flex max-w-4xl flex-col gap-6 px-4">
                <div class="flex flex-col gap-4 rounded-3xl border border-emerald-50 bg-white/95 p-6 shadow-lg">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">Pontuação atual</p>
                            <p class="text-3xl font-bold text-slate-900">{{ score }} pts</p>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <div class="rounded-full bg-emerald-50 px-4 py-2 font-semibold text-emerald-600">{{
                                quizMeta.reward }} XP</div>
                            <div class="text-slate-400">{{ currentQuestionIndex + 1 }}/{{ totalQuestions }} perguntas
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm font-semibold text-slate-500">
                            <span>{{ quizMeta.code }}</span>
                            <span>{{ progressPercent }}% concluído</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-emerald-500 transition-all duration-500"
                                :style="{ width: `${progressPercent}%` }"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-100 bg-white/95 p-6 shadow-xl">
                    <div class="mb-6">
                        <h1 class="text-xl font-bold text-slate-900">{{ currentQuestion.question }}</h1>
                        <p class="mt-1 text-sm text-slate-500">Escolha a alternativa correta para avançar no quiz.</p>
                    </div>
                    <div class="space-y-3">
                        <button v-for="option in currentQuestion.options" :key="option.id" type="button"
                            :class="optionClasses(option.id)" @click="selectOption(option.id)">
                            <div class="flex items-center">
                                <span :class="optionBadgeClasses(option.id)">{{ option.label }}</span>
                                <span>{{ option.text }}</span>
                            </div>
                            <div v-if="isAnswerRevealed.value && option.id === currentQuestion.correct"
                                class="flex items-center gap-2 text-sm font-semibold text-emerald-600">
                                <span
                                    class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                    ✓
                                </span>
                                Correta
                            </div>
                            <div v-else-if="isAnswerRevealed.value && option.id === selectedOption && option.id !== currentQuestion.correct"
                                class="text-sm font-semibold text-rose-500">
                                Sua escolha
                            </div>
                        </button>
                    </div>

                    <div class="mt-6">
                        <p v-if="feedbackMessage"
                            :class="['mb-4 text-sm font-semibold', feedbackType === 'correct' ? 'text-emerald-600' : 'text-rose-500']">
                            {{ feedbackMessage }}
                        </p>
                        <button type="button" :class="actionButtonClasses" @click="handlePrimaryAction"
                            :disabled="actionButtonDisabled">
                            {{ actionButtonLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <transition name="fade">
            <div v-if="showIntroModal" class="fixed inset-0 z-30 flex items-center justify-center bg-slate-900/60 px-4">
                <div class="w-full max-w-md rounded-3xl bg-white p-8 text-center shadow-2xl">
                    <h2 class="text-2xl font-bold text-slate-900">Pronto para começar?</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Revise as regras rápidas antes de iniciar. Este quiz verifica suas respostas em tempo real.
                    </p>
                    <ul class="mt-6 space-y-3 text-left text-sm text-slate-600">
                        <li class="flex items-center gap-3">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">⏱</span>
                            Limite de tempo: {{ quizMeta.timeLimit }}
                        </li>
                        <li class="flex items-center gap-3">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">❓</span>
                            Perguntas: {{ quizMeta.totalQuestions }}
                        </li>
                        <li class="flex items-center gap-3">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">⚡</span>
                            {{ quizMeta.info.join(' • ') }}
                        </li>
                    </ul>
                    <button type="button"
                        class="mt-8 rounded-button bg-emerald-500 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-600"
                        @click="startQuiz">
                        Começar quiz
                    </button>
                </div>
            </div>
        </transition>

        <transition name="fade">
            <div v-if="showSummaryModal"
                class="fixed inset-0 z-30 flex items-center justify-center bg-slate-900/60 px-4">
                <div class="w-full max-w-md rounded-3xl bg-white p-8 text-center shadow-2xl">
                    <h2 class="text-2xl font-bold text-slate-900">Resultados do quiz</h2>
                    <p class="mt-2 text-sm text-slate-500">Excelente trabalho! Continue praticando para subir no
                        ranking.</p>
                    <div class="mt-6 space-y-4 text-left">
                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700">
                            Pontos conquistados: <span class="text-xl font-bold">{{ score }} XP</span>
                        </div>
                        <div class="rounded-2xl border border-slate-100 px-4 py-3 text-slate-600">
                            Perguntas certas: <span class="font-bold">{{ Math.round(score / 50) }} / {{ totalQuestions
                                }}</span>
                        </div>
                    </div>
                    <button type="button"
                        class="mt-8 rounded-button bg-emerald-500 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-600"
                        @click="returnToDashboard">
                        Voltar ao dashboard
                    </button>
                </div>
            </div>
        </transition>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
