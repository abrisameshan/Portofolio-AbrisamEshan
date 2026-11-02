<script setup>
import { Camera, Code2, ShieldCheck, Terminal, Cpu, Layers } from 'lucide-vue-next';

defineProps({
    skillPillars: {
        type: Array,
        required: true,
    },
});

const getPillarIcon = (iconName) => {
    switch (iconName) {
        case 'Camera': return Camera;
        case 'Code2': return Code2;
        case 'ShieldCheck': return ShieldCheck;
        default: return Layers;
    }
};
</script>

<template>
    <section id="skills" class="py-20 md:py-28 relative border-t border-neutral-200 dark:border-neutral-800/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Section Header -->
            <div class="max-w-2xl mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-400 font-mono text-xs tracking-wider uppercase border border-neutral-200 dark:border-neutral-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    // CORE DISCIPLINES
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-neutral-950 dark:text-white mt-4">
                    Tiga Pilar Keahlian
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400 text-sm sm:text-base mt-2">
                    Kombinasi unik antara seni visual, engineering logika aplikasi, dan ketahanan infrastruktur jaringan.
                </p>
            </div>

            <!-- Pillars Grid in Clean Card Style -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    v-for="pillar in skillPillars"
                    :key="pillar.id"
                    class="card-shine group relative p-8 rounded-2xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800/80 hover:border-neutral-400 dark:hover:border-neutral-600 flex flex-col justify-between transition-all duration-300 shadow-sm"
                >
                    <div class="space-y-5">
                        <!-- Icon Circle -->
                        <div class="w-12 h-12 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700/60 flex items-center justify-center text-neutral-900 dark:text-white group-hover:scale-105 transition-transform">
                            <component :is="getPillarIcon(pillar.icon)" class="w-5 h-5 text-neutral-800 dark:text-neutral-200" />
                        </div>

                        <div>
                            <span class="text-[11px] font-mono text-neutral-500 dark:text-neutral-400 uppercase tracking-wider block">
                                {{ pillar.subtitle }}
                            </span>
                            <h3 class="text-lg sm:text-xl font-bold text-neutral-950 dark:text-white mt-1">
                                {{ pillar.title }}
                            </h3>
                        </div>

                        <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed font-normal">
                            {{ pillar.description }}
                        </p>
                    </div>

                    <!-- Tech Tags in Clean Micro-Pill Style -->
                    <div class="pt-8 border-t border-neutral-100 dark:border-neutral-800/80 mt-8">
                        <div class="text-[10px] font-mono text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-3">
                            Stack & Competencies:
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <span
                                v-for="tag in pillar.tags"
                                :key="tag"
                                class="px-2.5 py-1 rounded-md text-xs font-mono bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-neutral-700 dark:text-neutral-300"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Integrated Architecture Banner -->
            <div class="mt-12 p-6 rounded-2xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center shrink-0">
                        <Cpu class="w-5 h-5 text-neutral-700 dark:text-neutral-300" />
                    </div>
                    <div>
                        <h4 class="text-neutral-950 dark:text-white font-semibold text-sm sm:text-base">Infrastruktur & Arsitektur Sistem Terintegrasi</h4>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-1 max-w-2xl leading-relaxed">
                            Bukan sekadar menulis kode antarmuka, tetapi memahami ekosistem sistem secara menyeluruh: konfigurasi routing & switching (MikroTik/Cisco), administrasi server Linux, containerization, hingga keamanan data berlapis.
                        </p>
                    </div>
                </div>
                <div class="shrink-0 flex items-center gap-3">
                    <span class="px-3 py-1.5 rounded-full bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Production & Lab Ready
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>
