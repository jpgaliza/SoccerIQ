<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    questions: {
        type: Array,
        default: () => []
    }
});

const quizMeta = {
    code: 'Quiz SoccerIQ',
    timeLimit: '5 minutos',
    totalQuestions: 10,
    info: ['10 perguntas aleatórias', '4 alternativas por pergunta', '30 segundos por questão', 'Máximo 100 pts por pergunta'],
};

const showIntroModal = ref(true);
const showSummaryModal = ref(false);
const currentQuestionIndex = ref(0);
const selectedOption = ref(null);
const isAnswerRevealed = ref(false);
const score = ref(0);
const feedbackMessage = ref('');
const feedbackType = ref('neutral');
const quizId = ref(null);
const isLoading = ref(false);

// Dados finais do quiz
const finalQuizData = ref(null);

// Timer vars
const timeLeft = ref(30);
const timer = ref(null);
const questionStartTime = ref(null);
const quizStartTime = ref(null);

const totalQuestions = props.questions.length;
const currentQuestion = computed(() => props.questions[currentQuestionIndex.value]);

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

const formatTime = (seconds) => {
    return `${Math.floor(seconds / 60)}:${(seconds % 60).toString().padStart(2, '0')}`;
};

const formatTotalTime = (totalSeconds) => {
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    return `${minutes}min ${seconds}s`;
};

const startTimer = () => {
    timeLeft.value = 30;
    questionStartTime.value = Date.now();
    timer.value = setInterval(() => {
        if (timeLeft.value > 0) {
            timeLeft.value--;
            if (timeLeft.value <= 0) {
                timeLeft.value = 0;
                handleTimeUp();
            }
        }
    }, 1000);
};

const stopTimer = () => {
    if (timer.value) {
        clearInterval(timer.value);
        timer.value = null;
    }
};

const handleTimeUp = () => {
    if (!isAnswerRevealed.value) {
        stopTimer(); // Parar timer quando tempo esgota
        timeLeft.value = 0;
        selectedOption.value = null;
        handlePrimaryAction();
    }
};

const selectOption = (optionId) => {
    if (isAnswerRevealed.value) return;
    selectedOption.value = optionId;
};

const startQuiz = async () => {
    showIntroModal.value = false;
    isLoading.value = true;

    try {
        const response = await axios.post(route('quiz.start'));
        quizId.value = response.data.quiz_id;
        quizStartTime.value = Date.now();
        startTimer();
    } catch (error) {
        console.error('Erro ao iniciar quiz:', error);
        alert('Erro ao iniciar quiz. Tente novamente.');
    } finally {
        isLoading.value = false;
    }
}; const handlePrimaryAction = async () => {
    if (!isAnswerRevealed.value) {
        stopTimer();
        isAnswerRevealed.value = true;
        isLoading.value = true;

        const timeTaken = selectedOption.value ? Math.floor((Date.now() - questionStartTime.value) / 1000) : 30;

        try {
            const response = await axios.post(route('quiz.answer'), {
                quiz_id: quizId.value,
                question_id: currentQuestion.value.id,
                user_answer: selectedOption.value || '999', // 999 para respostas não respondidas
                time_taken: timeTaken
            });

            const pointsEarned = response.data.points_earned;
            score.value = response.data.total_score;

            if (response.data.is_correct) {
                feedbackMessage.value = `Resposta correta! +${pointsEarned} pts.`;
                feedbackType.value = 'correct';
            } else {
                feedbackMessage.value = selectedOption.value ? 'Resposta incorreta. Continue focado!' : 'Tempo esgotado!';
                feedbackType.value = 'incorrect';
            }
        } catch (error) {
            console.error('Erro ao enviar resposta:', error);
            feedbackMessage.value = 'Erro ao processar resposta';
            feedbackType.value = 'incorrect';
        } finally {
            isLoading.value = false;
        }
        return;
    }

    if (currentQuestionIndex.value === totalQuestions - 1) {
        // Finalizar quiz
        isLoading.value = true;
        const totalTimeSeconds = Math.floor((Date.now() - quizStartTime.value) / 1000);
        try {
            const response = await axios.post(route('quiz.finish'), {
                quiz_id: quizId.value,
                total_time_seconds: totalTimeSeconds
            });
            finalQuizData.value = {
                ...response.data.quiz,
                total_time_seconds: totalTimeSeconds
            };
            showSummaryModal.value = true;
        } catch (error) {
            console.error('Erro ao finalizar quiz:', error);
        } finally {
            isLoading.value = false;
        }
        return;
    }

    // Próxima pergunta
    currentQuestionIndex.value += 1;
    selectedOption.value = null;
    isAnswerRevealed.value = false;
    feedbackMessage.value = '';
    feedbackType.value = 'neutral';
    startTimer();
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

onUnmounted(() => {
    stopTimer();
});
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
                            <div class="rounded-full px-4 py-2 font-semibold"
                                :class="timeLeft <= 5 ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600'">
                                {{ formatTime(timeLeft) }}
                            </div>
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
                                class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-timer-icon lucide-timer">
                                    <line x1="10" x2="14" y1="2" y2="2" />
                                    <line x1="12" x2="15" y1="14" y2="11" />
                                    <circle cx="12" cy="14" r="8" />
                                </svg>
                            </span>
                            Limite de tempo: {{ quizMeta.timeLimit }}
                        </li>
                        <li class="flex items-center gap-3">
                            <span
                                class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-circle-question-mark-icon lucide-circle-question-mark">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                    <path d="M12 17h.01" />
                                </svg>
                            </span>
                            Perguntas: {{ quizMeta.totalQuestions }}
                        </li>
                        <li class="flex items-center gap-3">
                            <span
                                class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap">
                                    <path
                                        d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z" />
                                </svg>
                            </span>
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
                            Pontos conquistados: <span class="text-xl font-bold">{{ score }} pts</span>
                        </div>
                        <div class="rounded-2xl border border-slate-100 px-4 py-3 text-slate-600">
                            Tempo total: <span class="font-bold">{{ finalQuizData ?
                                formatTotalTime(finalQuizData.total_time_seconds) : '—' }}</span>
                        </div>
                        <div class="rounded-2xl border border-slate-100 px-4 py-3 text-slate-600">
                            Precisão: <span class="font-bold">{{ finalQuizData ? finalQuizData.accuracy : 0 }}%</span>
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
