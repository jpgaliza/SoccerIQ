<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const features = [
    {
        key: 'compete',
        title: 'Competir',
        description: 'Desafie amigos e suba no ranking global.',
    },
    {
        key: 'learn',
        title: 'Aprender',
        description: 'Receba explicações de especialistas para evoluir a cada pergunta.',
    },
    {
        key: 'track',
        title: 'Acompanhar Progresso',
        description: 'Monitore seu desempenho e visualize estatísticas detalhadas.',
    },
];

const stats = [
    { value: '10K+', label: 'Jogadores ativos' },
    { value: '500+', label: 'Perguntas de especialistas' },
    { value: '4.9/5', label: 'Avaliação dos jogadores' },
];
</script>

<template>

    <Head title="Bem-vindo" />

    <div class="min-h-screen bg-gradient-to-b from-neutral-50 via-white to-white text-slate-900">
        <div class="mx-auto flex max-w-6xl flex-col px-6 py-8 lg:px-10">
            <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500 text-lg font-bold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-trophy-icon lucide-trophy">
                            <path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978" />
                            <path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978" />
                            <path d="M18 9h1.5a1 1 0 0 0 0-5H18" />
                            <path d="M4 22h16" />
                            <path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z" />
                            <path d="M6 9H4.5a1 1 0 0 1 0-5H6" />
                        </svg>
                    </div>
                    <span class="text-xl font-semibold">SoccerIQ</span>
                </div>

                <div v-if="props.canLogin" class="flex items-center gap-3 text-sm font-semibold">
                    <Link :href="route('login')"
                        class="rounded-button border border-emerald-500 px-5 py-2 text-emerald-600 transition hover:bg-emerald-50">
                    Entrar
                    </Link>
                    <Link v-if="props.canRegister" :href="route('register')"
                        class="rounded-button bg-emerald-500 px-5 py-2 text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-600">
                    Criar conta
                    </Link>
                </div>
            </header>

            <main class="grid flex-1 grid-cols-1 gap-10 py-32 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)]">
                <section class="max-w-2xl space-y-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-400">
                        Compita &bull; Aprenda &bull; Acompanhe
                    </p>
                    <h1 class="text-4xl font-bold leading-tight sm:text-5xl">
                        Teste seus conhecimentos
                        <span class="text-emerald-500">sobre futebol</span>
                    </h1>
                    <p class="text-lg text-slate-600">
                        Desafie-se com perguntas de futebol em nível especialista, dispute com jogadores do mundo todo e
                        acompanhe sua evolução.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <Link :href="route('login')"
                            class="flex items-center gap-2 rounded-button bg-emerald-500 px-7 py-3 text-base font-semibold text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-zap-icon lucide-zap">
                            <path
                                d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z" />
                        </svg>
                        Iniciar quiz
                        </Link>
                        <Link :href="route('login')"
                            class="rounded-button border border-emerald-500 px-7 py-3 text-base font-semibold text-emerald-600 transition hover:bg-emerald-50">
                        Ver pontuação
                        </Link>
                    </div>
                </section>

                <section class="flex flex-col gap-4">
                    <article v-for="feature in features" :key="feature.title"
                        class="feature-layer card-glow rounded-3xl p-5">
                        <div class="mb-4 flex items-center">
                            <div
                                class="inline-flex h-12 w-12 items-center justify-center rounded-2xl text-base font-semibold text-emerald-600">
                                <svg v-if="feature.key === 'track'" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-zap-icon lucide-zap" aria-hidden="true">
                                    <path
                                        d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z" />
                                </svg>
                                <!-- <span v-else aria-hidden="true">{{ feature.icon }}</span> -->
                                <svg v-if="feature.key === 'learn'" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-users-icon lucide-users">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg>
                                <svg v-if="feature.key === 'compete'" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-trophy-icon lucide-trophy">
                                    <path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978" />
                                    <path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978" />
                                    <path d="M18 9h1.5a1 1 0 0 0 0-5H18" />
                                    <path d="M4 22h16" />
                                    <path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z" />
                                    <path d="M6 9H4.5a1 1 0 0 1 0-5H6" />
                                </svg>
                            </div>
                            <h3 class="text-right text-lg font-semibold">{{ feature.title }}</h3>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">{{ feature.description }}</p>
                    </article>
                </section>
            </main>
        </div>
        <footer class="bg-neutral-primary-soft rounded-base shadow-xs border border-default">
            <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <a href="https://socceriq.com/"
                        class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500 text-lg font-bold text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy">
                                <path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978" />
                                <path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978" />
                                <path d="M18 9h1.5a1 1 0 0 0 0-5H18" />
                                <path d="M4 22h16" />
                                <path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z" />
                                <path d="M6 9H4.5a1 1 0 0 1 0-5H6" />
                            </svg>
                        </div>
                        <span class="text-xl font-semibold">SoccerIQ</span>
                    </a>
                    <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-body sm:mb-0">
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Sobre</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Política de Privacidade</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Licenciamento</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">Contato</a>
                        </li>
                    </ul>
                </div>
                <hr class="my-6 border-default sm:mx-auto lg:my-4" />
                <span class="block text-sm text-body sm:text-center">© 2025 <a href="https://flowbite.com/"
                        class="hover:underline">SoccerIQ</a>. Todos os direitos reservados.</span>
            </div>
        </footer>
    </div>
</template>
