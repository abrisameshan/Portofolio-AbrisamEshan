<script setup>
import { ArrowUp, Terminal } from 'lucide-vue-next';
import SocialIcon from '@/Components/SocialIcon.vue';

defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['toggleTerminal']);

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<template>
    <footer class="border-t border-neutral-200 dark:border-neutral-800/80 bg-neutral-100/50 dark:bg-[#09090b] py-14 text-neutral-600 dark:text-neutral-400 transition-colors">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Branding -->
                <div class="flex items-center gap-3 text-center md:text-left">
                    <img
                        src="/images/logo.jpg"
                        alt="Haans.ID"
                        class="w-9 h-9 rounded-full object-cover bg-white ring-1 ring-neutral-200 dark:ring-neutral-700 shadow-sm shrink-0"
                    />
                    <div>
                        <div class="text-sm font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                            {{ profile.name }}
                            <span class="text-[10px] font-mono px-1.5 py-0.2 rounded bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                                SIJA
                            </span>
                        </div>
                        <div class="text-xs font-mono text-neutral-500 dark:text-neutral-400">{{ profile.role }}</div>
                    </div>
                </div>

                <!-- 7 Social Media Icons -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <a
                        v-for="social in profile.social_links"
                        :key="social.name"
                        :href="social.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="p-2 rounded-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white hover:border-neutral-400 dark:hover:border-neutral-600 transition-all shadow-sm hover:scale-105"
                        :title="social.name + ' (' + social.handle + ')'"
                        :aria-label="social.name"
                    >
                        <SocialIcon :name="social.icon" class-name="w-4 h-4" />
                    </a>

                    <div class="w-px h-5 bg-neutral-200 dark:bg-neutral-800 mx-1 hidden sm:block"></div>

                    <!-- Terminal Toggle -->
                    <button
                        @click="emit('toggleTerminal')"
                        class="p-2 rounded-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-emerald-500 hover:border-neutral-400 dark:hover:border-neutral-600 transition-colors shadow-sm"
                        title="Open CLI"
                    >
                        <Terminal class="w-4 h-4" />
                    </button>

                    <!-- Scroll to Top -->
                    <button
                        @click="scrollToTop"
                        class="p-2 rounded-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white hover:border-neutral-400 dark:hover:border-neutral-600 transition-colors shadow-sm"
                        aria-label="Back to top"
                    >
                        <ArrowUp class="w-4 h-4" />
                    </button>
                </div>
            </div>

            <div class="pt-8 border-t border-neutral-200 dark:border-neutral-800/80 flex flex-col sm:flex-row items-center justify-between text-xs font-mono text-neutral-500 dark:text-neutral-400 gap-4">
                <div>
                    &copy; {{ new Date().getFullYear() }} {{ profile.name }}. Designed with Clean Minimalist aesthetic.
                </div>
                <div class="flex items-center gap-1.5">
                    <span>Engine:</span>
                    <span class="text-neutral-800 dark:text-neutral-200 font-semibold">Laravel 11</span>
                    <span>&bull;</span>
                    <span class="text-neutral-800 dark:text-neutral-200 font-semibold">Vue 3</span>
                    <span>&bull;</span>
                    <span class="text-neutral-800 dark:text-neutral-200 font-semibold">Inertia.js</span>
                    <span>&bull;</span>
                    <span class="text-neutral-800 dark:text-neutral-200 font-semibold">Tailwind</span>
                </div>
            </div>
        </div>
    </footer>
</template>
