<script setup>
import { ref, computed } from 'vue';
import { ExternalLink, Github, CheckCircle2, Shield, Network, Globe } from 'lucide-vue-next';

const props = defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const activeType = ref('All');

const types = ['All', 'Web Development', 'Networking & Labs', 'Cybersecurity'];

const filteredProjects = computed(() => {
    if (activeType.value === 'All') return props.projects;
    if (activeType.value === 'Web Development') {
        return props.projects.filter(p => p.type.includes('Web'));
    }
    if (activeType.value === 'Networking & Labs') {
        return props.projects.filter(p => p.type.includes('Networking') || p.type.includes('Infrastructure'));
    }
    if (activeType.value === 'Cybersecurity') {
        return props.projects.filter(p => p.type.includes('Cybersecurity'));
    }
    return props.projects;
});

const getTypeIcon = (type) => {
    if (type.includes('Cybersecurity')) return Shield;
    if (type.includes('Networking') || type.includes('Infrastructure')) return Network;
    return Globe;
};
</script>

<template>
    <section id="projects" class="py-20 md:py-28 relative border-t border-neutral-200 dark:border-neutral-800/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-400 font-mono text-xs tracking-wider uppercase border border-neutral-200 dark:border-neutral-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                        // DEPLOYED REPOSITORIES & LABS
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-neutral-950 dark:text-white mt-4">
                        Proyek & Praktikum Lab
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm sm:text-base mt-2 max-w-xl">
                        Portofolio implementasi aplikasi web modern (Laravel + Vue), simulasi arsitektur jaringan enterprise, dan tooling keamanan siber.
                    </p>
                </div>

                <!-- Clean Filter Tabs -->
                <div class="flex flex-wrap items-center gap-1.5 p-1 rounded-full bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                    <button
                        v-for="type in types"
                        :key="type"
                        @click="activeType = type"
                        class="px-3.5 py-1.5 rounded-full text-xs font-mono transition-all duration-200"
                        :class="[
                            activeType === type
                                ? 'bg-white dark:bg-neutral-800 text-neutral-950 dark:text-white font-bold shadow-sm'
                                : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white'
                        ]"
                    >
                        {{ type }}
                    </button>
                </div>
            </div>

            <!-- Projects Grid in Clean Card Style -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    v-for="project in filteredProjects"
                    :key="project.id"
                    class="card-shine group relative p-7 rounded-2xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800/80 hover:border-neutral-400 dark:hover:border-neutral-600 flex flex-col justify-between transition-all duration-300 shadow-sm"
                >
                    <div class="space-y-4">
                        <!-- Top Metadata Bar -->
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-2 text-xs font-mono text-neutral-600 dark:text-neutral-400">
                                <component :is="getTypeIcon(project.type)" class="w-3.5 h-3.5 text-neutral-500" />
                                <span>{{ project.type }}</span>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300">
                                {{ project.badge }}
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-neutral-950 dark:text-white group-hover:text-neutral-900 dark:group-hover:text-neutral-100 transition-colors">
                                {{ project.title }}
                            </h3>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-2.5 leading-relaxed font-normal">
                                {{ project.description }}
                            </p>
                        </div>

                        <!-- Highlights List -->
                        <div class="space-y-1.5 pt-2">
                            <div
                                v-for="(highlight, idx) in project.highlights"
                                :key="idx"
                                class="flex items-center gap-2 text-xs text-neutral-700 dark:text-neutral-300 font-mono"
                            >
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                <span>{{ highlight }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tech Stack & Action Links -->
                    <div class="pt-6 border-t border-neutral-100 dark:border-neutral-800/80 mt-6 space-y-4">
                        <!-- Tech Badges -->
                        <div class="flex flex-wrap gap-1.5">
                            <span
                                v-for="t in project.stack"
                                :key="t"
                                class="px-2.5 py-1 rounded-md text-xs font-mono bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-neutral-700 dark:text-neutral-300"
                            >
                                {{ t }}
                            </span>
                        </div>

                        <!-- Action Links in Clean Style -->
                        <div class="flex items-center gap-2.5 pt-1">
                            <a
                                v-if="project.github"
                                :href="project.github"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-xs font-mono text-neutral-900 dark:text-white hover:border-neutral-400 dark:hover:border-neutral-500 transition-colors"
                            >
                                <Github class="w-3.5 h-3.5" />
                                <span>Repository</span>
                            </a>
                            <a
                                v-if="project.demo"
                                :href="project.demo"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 text-xs font-semibold hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-colors shadow-sm"
                            >
                                <span>Live Demo</span>
                                <ExternalLink class="w-3.5 h-3.5" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
