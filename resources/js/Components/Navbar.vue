<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Terminal, Menu, X, ArrowUpRight, Sun, Moon } from 'lucide-vue-next';
import { useTheme } from '@/Composables/useTheme';

defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['toggleTerminal']);

const { isDark, initTheme, toggleTheme } = useTheme();

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    initTheme();
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const navItems = [
    { name: 'About', href: '#top' },
    { name: 'Disciplines', href: '#skills' },
    { name: 'Gallery', href: '#photography' },
    { name: 'Projects', href: '#projects' },
    { name: 'Contact', href: '#contact' },
];
</script>

<template>
    <header class="fixed top-0 left-0 right-0 z-40 py-4 sm:py-5 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div
                class="flex items-center justify-between px-4 sm:px-5 py-2.5 rounded-full transition-all duration-300"
                :class="[
                    isScrolled
                        ? 'bg-white/80 dark:bg-[#0c0c0e]/80 backdrop-blur-xl border border-neutral-200/80 dark:border-neutral-800/80 shadow-[0_4px_20px_rgba(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.6)]'
                        : 'bg-white/40 dark:bg-[#0c0c0e]/40 backdrop-blur-md border border-neutral-200/60 dark:border-neutral-800/50'
                ]"
            >
                <!-- Brand / Avatar & Full Name in Ultra-Clean Style -->
                <a href="#top" class="group flex items-center gap-2.5">
                    <img
                        src="/images/avatar.jpg"
                        alt="Abrisam Daniel Kuncoro Eshan"
                        class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover object-top ring-1 ring-neutral-300 dark:ring-neutral-700 group-hover:scale-105 group-hover:ring-neutral-900 dark:group-hover:ring-white transition-all shadow-sm shrink-0"
                    />
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="font-bold tracking-tight text-neutral-900 dark:text-white text-xs sm:text-sm font-sans truncate">
                            Abrisam Daniel Kuncoro Eshan
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-1">
                    <a
                        v-for="item in navItems"
                        :key="item.name"
                        :href="item.href"
                        class="px-3.5 py-1.5 text-xs font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white rounded-full transition-colors hover:bg-neutral-100 dark:hover:bg-neutral-800/50"
                    >
                        {{ item.name }}
                    </a>
                </nav>

                <!-- Action Controls: Theme Switcher & Terminal & CTA -->
                <div class="hidden md:flex items-center gap-2">
                    <!-- Light / Dark Mode Switcher -->
                    <button
                        @click="toggleTheme"
                        class="p-2 rounded-full text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800/60 transition-colors"
                        :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                        aria-label="Toggle theme"
                    >
                        <Sun v-if="isDark" class="w-4 h-4 text-amber-300" />
                        <Moon v-else class="w-4 h-4 text-neutral-700" />
                    </button>

                    <!-- Terminal Console Trigger -->
                    <button
                        @click="emit('toggleTerminal')"
                        class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-600 dark:text-neutral-300 hover:border-neutral-400 dark:hover:border-neutral-600 transition-colors"
                        title="Open CLI"
                    >
                        <Terminal class="w-3.5 h-3.5 text-neutral-500 dark:text-neutral-400 group-hover:text-emerald-500" />
                        <span>CLI</span>
                        <kbd class="text-[9px] px-1 py-0.2 rounded bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 font-mono text-neutral-500 dark:text-neutral-400">
                            `
                        </kbd>
                    </button>

                    <!-- Contact Pill -->
                    <a
                        href="#contact"
                        class="flex items-center gap-1.5 px-4 py-1.5 text-xs font-semibold rounded-full bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-all shadow-sm"
                    >
                        <span>Collaborate</span>
                        <ArrowUpRight class="w-3 h-3" />
                    </a>
                </div>

                <!-- Mobile Trigger -->
                <div class="flex items-center gap-1 md:hidden">
                    <button
                        @click="toggleTheme"
                        class="p-2 rounded-full text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                        aria-label="Toggle theme"
                    >
                        <Sun v-if="isDark" class="w-4 h-4 text-amber-300" />
                        <Moon v-else class="w-4 h-4 text-neutral-700" />
                    </button>

                    <button
                        @click="emit('toggleTerminal')"
                        class="p-2 rounded-full text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                        title="CLI"
                    >
                        <Terminal class="w-4 h-4 text-emerald-500" />
                    </button>

                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-full text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                    >
                        <Menu v-if="!mobileMenuOpen" class="w-4 h-4" />
                        <X v-else class="w-4 h-4" />
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer -->
            <div
                v-if="mobileMenuOpen"
                class="md:hidden mt-2 p-4 bg-white/95 dark:bg-[#0c0c0e]/95 backdrop-blur-2xl border border-neutral-200 dark:border-neutral-800 rounded-2xl space-y-2 shadow-xl"
            >
                <a
                    v-for="item in navItems"
                    :key="item.name"
                    :href="item.href"
                    @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-xs font-medium text-neutral-700 dark:text-neutral-300 hover:text-neutral-950 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800/50 rounded-xl"
                >
                    {{ item.name }}
                </a>
                <div class="pt-2 border-t border-neutral-200 dark:border-neutral-800">
                    <a
                        href="#contact"
                        @click="mobileMenuOpen = false"
                        class="block text-center py-2 text-xs font-semibold rounded-xl bg-neutral-950 dark:bg-white text-white dark:text-neutral-950"
                    >
                        Collaborate
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>
