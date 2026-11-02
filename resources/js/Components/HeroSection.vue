<script setup>
import { Camera, Code2, Shield, Terminal, ArrowDown, ArrowUpRight } from 'lucide-vue-next';

defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['toggleTerminal']);
</script>

<template>
    <section id="top" class="relative pt-36 pb-20 md:pt-48 md:pb-28 overflow-hidden">
        <!-- Ambient Clean Background Pattern -->
        <div class="absolute inset-0 pointer-events-none -z-10 ambient-glow"></div>
        <div class="absolute inset-0 pointer-events-none -z-10 clean-grid [mask-image:radial-gradient(ellipse_60%_50%_at_50%_20%,#000_70%,transparent_100%)]"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center space-y-8">
                <!-- Status Pill in Ultra-Clean Style -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-neutral-100/80 dark:bg-neutral-900/80 border border-neutral-200/80 dark:border-neutral-800 text-xs text-neutral-600 dark:text-neutral-300 font-mono shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="font-medium text-neutral-800 dark:text-neutral-200">SIJA STUDENT & DEVELOPER</span>
                    <span class="text-neutral-300 dark:text-neutral-700">/</span>
                    <span class="text-neutral-500 dark:text-neutral-400">PHOTOGRAPHER</span>
                </div>

                <!-- Main Bold Title -->
                <div class="space-y-4 max-w-3xl mx-auto">
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-neutral-950 dark:text-white leading-[1.08]">
                        Framing Stories. <br />
                        <span class="text-neutral-500 dark:text-neutral-400 font-light">
                            Engineering Systems.
                        </span> <br />
                        <span class="font-mono text-3xl sm:text-5xl md:text-6xl text-neutral-800 dark:text-neutral-100 font-semibold tracking-tight">
                            &lt;Securing Nodes/&gt;
                        </span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-base sm:text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed font-normal">
                        Halo! Saya <strong class="text-neutral-900 dark:text-white font-semibold">{{ profile.name }}</strong> ({{ profile.age }} tahun), siswa jurusan <strong class="text-neutral-900 dark:text-white font-semibold">SIJA</strong> di Yogyakarta yang aktif sebagai web developer dan fotografer. Mengombinasikan fotografi visual lewat kamera <strong class="text-neutral-900 dark:text-white font-mono">{{ profile.camera }}</strong> dengan rekayasa web modern (<span class="text-neutral-900 dark:text-white underline decoration-neutral-300 dark:decoration-neutral-700 underline-offset-4">Laravel & Vue</span>) serta arsitektur jaringan dan dasar keamanan sistem.
                    </p>
                </div>

                <!-- Precision Disciplines Chips -->
                <div class="flex flex-wrap items-center justify-center gap-2.5 pt-1">
                    <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-700 dark:text-neutral-300 shadow-sm">
                        <Camera class="w-3.5 h-3.5 text-neutral-500" />
                        <span>Canon 60D Photography</span>
                    </div>
                    <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-700 dark:text-neutral-300 shadow-sm">
                        <Code2 class="w-3.5 h-3.5 text-neutral-500" />
                        <span>Laravel 11 & Vue 3 Dev</span>
                    </div>
                    <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-700 dark:text-neutral-300 shadow-sm">
                        <Shield class="w-3.5 h-3.5 text-neutral-500" />
                        <span>SIJA: Network & Cyber Sec</span>
                    </div>
                </div>

                <!-- Primary Action Buttons in Linear Style -->
                <div class="flex flex-wrap items-center justify-center gap-3.5 pt-4">
                    <a
                        href="#photography"
                        class="px-6 py-3 rounded-full bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 font-semibold text-xs sm:text-sm hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-all shadow-sm hover:scale-[1.02] flex items-center gap-2"
                    >
                        <Camera class="w-4 h-4" />
                        <span>Explore Gallery</span>
                    </a>
                    <a
                        href="#projects"
                        class="px-6 py-3 rounded-full bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-800 dark:text-neutral-200 font-semibold text-xs sm:text-sm hover:border-neutral-400 dark:hover:border-neutral-600 transition-all flex items-center gap-2 shadow-sm"
                    >
                        <Code2 class="w-4 h-4 text-neutral-500" />
                        <span>View Projects</span>
                    </a>
                    <button
                        @click="emit('toggleTerminal')"
                        class="px-4 py-3 rounded-full bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-400 font-mono text-xs hover:text-neutral-950 dark:hover:text-white hover:border-neutral-400 dark:hover:border-neutral-600 transition-all flex items-center gap-2"
                    >
                        <Terminal class="w-3.5 h-3.5 text-emerald-500" />
                        <span>Console</span>
                    </button>
                </div>

                <!-- Clean Minimalist Stats Bar -->
                <div class="pt-12 grid grid-cols-2 md:grid-cols-4 gap-3 max-w-3xl mx-auto">
                    <div
                        v-for="stat in profile.stats"
                        :key="stat.label"
                        class="p-4 rounded-2xl bg-white dark:bg-neutral-900/60 border border-neutral-200 dark:border-neutral-800/80 text-center shadow-sm"
                    >
                        <div class="text-xl sm:text-2xl font-bold font-mono text-neutral-950 dark:text-white tracking-tight">{{ stat.value }}</div>
                        <div class="text-[10px] sm:text-[11px] font-mono text-neutral-500 dark:text-neutral-400 mt-1 uppercase tracking-wider">{{ stat.label }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
