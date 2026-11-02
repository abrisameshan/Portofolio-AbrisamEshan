<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import HeroSection from '@/Components/HeroSection.vue';
import SkillPillars from '@/Components/SkillPillars.vue';
import PhotoGallery from '@/Components/PhotoGallery.vue';
import ProjectShowcase from '@/Components/ProjectShowcase.vue';
import ContactSection from '@/Components/ContactSection.vue';
import Footer from '@/Components/Footer.vue';
import TerminalDrawer from '@/Components/TerminalDrawer.vue';
import { useTheme } from '@/Composables/useTheme';

defineProps({
    profile: {
        type: Object,
        required: true,
    },
    skillPillars: {
        type: Array,
        required: true,
    },
    photos: {
        type: Array,
        required: true,
    },
    projects: {
        type: Array,
        required: true,
    },
});

const { initTheme } = useTheme();
const isTerminalOpen = ref(false);

const toggleTerminal = () => {
    isTerminalOpen.value = !isTerminalOpen.value;
};

const handleKeyDown = (e) => {
    // Press ` or Ctrl + ` to toggle CLI
    if (e.key === '`' && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
        e.preventDefault();
        toggleTerminal();
    }
};

onMounted(() => {
    initTheme();
    window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeyDown);
});
</script>

<template>
    <Head :title="profile.name + ' • SIJA Student, Developer & Photographer'" />

    <div class="min-h-screen bg-[#fafafa] dark:bg-[#09090b] text-neutral-900 dark:text-neutral-100 font-sans selection:bg-neutral-800 selection:text-white dark:selection:bg-neutral-200 dark:selection:text-neutral-950 transition-colors duration-300">
        <!-- Navigation Bar with Light/Dark Mode Switcher -->
        <Navbar
            :profile="profile"
            @toggle-terminal="toggleTerminal"
        />

        <main>
            <!-- Hero Section -->
            <HeroSection
                :profile="profile"
                @toggle-terminal="toggleTerminal"
            />

            <!-- Skill Pillars -->
            <SkillPillars
                :skill-pillars="skillPillars"
            />

            <!-- Photography Gallery -->
            <PhotoGallery
                :photos="photos"
            />

            <!-- Projects & Labs -->
            <ProjectShowcase
                :projects="projects"
            />

            <!-- Contact Section -->
            <ContactSection
                :profile="profile"
            />
        </main>

        <!-- Footer -->
        <Footer
            :profile="profile"
            @toggle-terminal="toggleTerminal"
        />

        <!-- Interactive Terminal Modal -->
        <TerminalDrawer
            :is-open="isTerminalOpen"
            @close="isTerminalOpen = false"
        />

        <!-- Floating Quick Terminal Trigger -->
        <div class="fixed bottom-6 right-6 z-30 hidden sm:block">
            <button
                @click="toggleTerminal"
                class="group flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white shadow-lg backdrop-blur-md transition-all hover:scale-105"
                title="Press ` for CLI"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[11px]">Console</span>
                <kbd class="px-1.5 py-0.2 rounded bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-[10px] text-neutral-700 dark:text-neutral-300">`</kbd>
            </button>
        </div>
    </div>
</template>
