<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import { Lock, ArrowLeft, ShieldCheck, KeyRound, Sun, Moon } from 'lucide-vue-next';
import { useTheme } from '@/Composables/useTheme';

const { isDark, toggleTheme } = useTheme();

const form = useForm({
    passcode: '',
});

const submit = () => {
    form.post('/inbox/login', {
        onFinish: () => form.reset('passcode'),
    });
};
</script>

<template>
    <Head title="Verifikasi Akses Admin • Inbox" />

    <div class="min-h-screen bg-[#fafafa] dark:bg-[#09090b] text-neutral-900 dark:text-neutral-100 flex flex-col justify-center items-center p-4 transition-colors duration-300">
        <!-- Top Switcher & Return Link -->
        <div class="fixed top-6 left-6 right-6 flex items-center justify-between max-w-xl mx-auto w-full">
            <Link
                href="/"
                class="inline-flex items-center gap-2 text-xs font-mono text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white transition-colors"
            >
                <ArrowLeft class="w-4 h-4" />
                <span>Kembali ke Portofolio</span>
            </Link>

            <button
                @click="toggleTheme"
                class="p-2 rounded-xl text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-800 transition-colors"
                aria-label="Toggle theme"
            >
                <Sun v-if="isDark" class="w-4 h-4 text-amber-300" />
                <Moon v-else class="w-4 h-4 text-neutral-700" />
            </button>
        </div>

        <div class="w-full max-w-sm space-y-6">
            <!-- Header Icon & Title -->
            <div class="text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-neutral-900 dark:bg-white text-white dark:text-neutral-950 flex items-center justify-center mx-auto shadow-sm">
                    <Lock class="w-5 h-5" />
                </div>
                <h1 class="text-xl font-bold tracking-tight text-neutral-950 dark:text-white">
                    Akses Terbatas: Inbox
                </h1>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed font-sans">
                    Halaman ini diproteksi khusus untuk pemilik portofolio. Silakan masukkan passcode admin kamu.
                </p>
            </div>

            <!-- Passcode Form -->
            <div class="p-6 rounded-2xl bg-white dark:bg-neutral-900/60 border border-neutral-200 dark:border-neutral-800 shadow-sm space-y-4">
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="passcode" class="block text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider mb-1.5">
                            Passcode Admin
                        </label>
                        <div class="relative">
                            <input
                                id="passcode"
                                v-model="form.passcode"
                                type="password"
                                required
                                autofocus
                                placeholder="Masukkan passcode..."
                                class="w-full pl-3.5 pr-10 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-sm text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:border-neutral-400 dark:focus:border-neutral-600 font-mono tracking-wider transition-colors"
                            />
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400">
                                <KeyRound class="w-4 h-4" />
                            </div>
                        </div>
                        <span v-if="form.errors.passcode" class="text-xs text-rose-500 mt-1.5 block font-mono">
                            {{ form.errors.passcode }}
                        </span>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-2.5 px-4 rounded-xl bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 font-semibold text-xs hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-all shadow-sm disabled:opacity-50 flex items-center justify-center gap-2"
                    >
                        <ShieldCheck class="w-4 h-4" />
                        <span>{{ form.processing ? 'Memverifikasi...' : 'Buka Kunci Inbox' }}</span>
                    </button>
                </form>
            </div>

            <!-- Hint for Local Admin -->
            <div class="p-3 rounded-xl bg-neutral-100 dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800/80 text-[11px] font-mono text-neutral-500 dark:text-neutral-400 text-center leading-relaxed">
                Default Passcode: <span class="text-emerald-600 dark:text-emerald-400 font-bold">sija2026</span><br />
                <span class="text-[10px] text-neutral-400">(Dapat kamu ganti kapan saja di file <code class="text-neutral-700 dark:text-neutral-300">.env</code>)</span>
            </div>
        </div>
    </div>
</template>
