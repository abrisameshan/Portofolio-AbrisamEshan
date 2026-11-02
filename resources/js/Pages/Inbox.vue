<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { 
    Mail, ArrowLeft, Trash2, CheckCircle2, Eye, EyeOff, 
    Reply, Clock, Inbox as InboxIcon, Filter, Sun, Moon, LogOut 
} from 'lucide-vue-next';
import { useTheme } from '@/Composables/useTheme';

const props = defineProps({
    messages: {
        type: Array,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
});

const { isDark, toggleTheme } = useTheme();

const activeFilter = ref('All');
const selectedMessage = ref(null);

const filters = ['All', 'Unread', 'General', 'Photography', 'Web Development', 'Network & IT'];

const filteredMessages = computed(() => {
    if (activeFilter.value === 'All') return props.messages;
    if (activeFilter.value === 'Unread') return props.messages.filter(m => !m.is_read);
    return props.messages.filter(m => m.service_type === activeFilter.value);
});

const toggleRead = (id) => {
    router.patch(`/inbox/${id}/toggle-read`, {}, { preserveScroll: true });
};

const deleteMessage = (id) => {
    if (confirm('Yakin ingin menghapus pesan ini?')) {
        router.delete(`/inbox/${id}`, { 
            preserveScroll: true,
            onSuccess: () => {
                if (selectedMessage.value?.id === id) {
                    selectedMessage.value = null;
                }
            }
        });
    }
};

const getBadgeColor = (type) => {
    switch (type) {
        case 'Photography': return 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20';
        case 'Web Development': return 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
        case 'Network & IT': return 'bg-purple-500/10 text-purple-600 dark:text-purple-400 border-purple-500/20';
        default: return 'bg-neutral-500/10 text-neutral-600 dark:text-neutral-400 border-neutral-500/20';
    }
};
</script>

<template>
    <Head title="Pesan Masuk (Inbox) • Portfolio" />

    <div class="min-h-screen bg-[#fafafa] dark:bg-[#09090b] text-neutral-900 dark:text-neutral-100 font-sans transition-colors duration-300">
        <!-- Top Header Navigation -->
        <header class="border-b border-neutral-200 dark:border-neutral-800 bg-white/70 dark:bg-[#0c0c0e]/70 backdrop-blur-xl sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <Link
                        href="/"
                        class="p-2 rounded-xl bg-neutral-100 dark:bg-neutral-800/80 text-neutral-600 dark:text-neutral-300 hover:text-neutral-950 dark:hover:text-white transition-colors"
                        title="Kembali ke Portofolio"
                    >
                        <ArrowLeft class="w-4 h-4" />
                    </Link>
                    <div>
                        <h1 class="text-base font-bold text-neutral-950 dark:text-white flex items-center gap-2">
                            <span>Inbox Pesan Kontak</span>
                            <span
                                v-if="stats.unread > 0"
                                class="px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-mono text-emerald-600 dark:text-emerald-400 font-semibold"
                            >
                                {{ stats.unread }} Baru
                            </span>
                        </h1>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 font-mono">
                            Daftar pesan yang dikirim pengunjung melalui formulir kontak
                        </p>
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    <button
                        @click="toggleTheme"
                        class="p-2 rounded-xl text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                        aria-label="Toggle theme"
                    >
                        <Sun v-if="isDark" class="w-4 h-4 text-amber-300" />
                        <Moon v-else class="w-4 h-4 text-neutral-700" />
                    </button>
                    <Link
                        href="/"
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                    >
                        <span>Lihat Web</span>
                    </Link>
                    <button
                        @click="router.post('/inbox/logout')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-xs font-mono text-rose-600 dark:text-rose-400 hover:bg-rose-500/20 transition-colors"
                        title="Kunci / Keluar dari Inbox"
                    >
                        <LogOut class="w-3.5 h-3.5" />
                        <span>Kunci</span>
                    </button>
                </div>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-6">
            <!-- Stats Bar -->
            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 rounded-2xl bg-white dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-800 shadow-sm">
                    <span class="text-xs font-mono text-neutral-500 uppercase tracking-wider block">Total Pesan</span>
                    <span class="text-2xl font-bold font-mono text-neutral-950 dark:text-white mt-1 block">{{ stats.total }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-white dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-800 shadow-sm">
                    <span class="text-xs font-mono text-emerald-600 dark:text-emerald-400 uppercase tracking-wider block">Belum Dibaca</span>
                    <span class="text-2xl font-bold font-mono text-emerald-600 dark:text-emerald-400 mt-1 block">{{ stats.unread }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-white dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-800 shadow-sm">
                    <span class="text-xs font-mono text-neutral-500 uppercase tracking-wider block">Sudah Dibaca</span>
                    <span class="text-2xl font-bold font-mono text-neutral-950 dark:text-white mt-1 block">{{ stats.read }}</span>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 pb-2">
                <button
                    v-for="filter in filters"
                    :key="filter"
                    @click="activeFilter = filter"
                    class="px-3 py-1.5 rounded-xl text-xs font-mono transition-all"
                    :class="[
                        activeFilter === filter
                            ? 'bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 font-bold shadow-sm'
                            : 'bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white'
                    ]"
                >
                    {{ filter }}
                </button>
            </div>

            <!-- Messages List & Detail -->
            <div v-if="filteredMessages.length === 0" class="text-center py-16 bg-white dark:bg-neutral-900/30 border border-neutral-200 dark:border-neutral-800 rounded-2xl">
                <InboxIcon class="w-10 h-10 text-neutral-400 mx-auto mb-3" />
                <h3 class="font-bold text-neutral-800 dark:text-neutral-200 text-base">Belum Ada Pesan</h3>
                <p class="text-xs text-neutral-500 mt-1 font-mono">Pesan yang dikirim pengunjung akan muncul di sini.</p>
            </div>

            <div v-else class="space-y-3">
                <div
                    v-for="msg in filteredMessages"
                    :key="msg.id"
                    class="p-5 rounded-2xl bg-white dark:bg-neutral-900/50 border transition-all duration-200 shadow-sm"
                    :class="[
                        !msg.is_read
                            ? 'border-emerald-500/40 bg-emerald-50/10 dark:bg-emerald-950/10'
                            : 'border-neutral-200 dark:border-neutral-800/80'
                    ]"
                >
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <!-- Sender & Message Preview -->
                        <div class="space-y-2 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-neutral-950 dark:text-white text-sm">
                                    {{ msg.name }}
                                </span>
                                <span class="text-xs text-neutral-500 font-mono">
                                    &lt;{{ msg.email }}&gt;
                                </span>
                                <span
                                    class="px-2 py-0.5 rounded-md text-[10px] font-mono border font-medium"
                                    :class="getBadgeColor(msg.service_type)"
                                >
                                    {{ msg.service_type }}
                                </span>
                                <span
                                    v-if="!msg.is_read"
                                    class="px-1.5 py-0.2 rounded bg-emerald-500 text-white text-[9px] font-mono font-bold uppercase"
                                >
                                    Baru
                                </span>
                            </div>

                            <!-- Subject -->
                            <div class="font-semibold text-neutral-900 dark:text-neutral-200 text-sm">
                                {{ msg.subject }}
                            </div>

                            <!-- Full Message Content -->
                            <div class="p-3.5 rounded-xl bg-neutral-50 dark:bg-neutral-950/60 border border-neutral-200 dark:border-neutral-800/80 text-xs text-neutral-800 dark:text-neutral-300 whitespace-pre-wrap leading-relaxed font-sans">
                                {{ msg.message }}
                            </div>

                            <div class="flex items-center gap-2 text-[11px] font-mono text-neutral-400">
                                <Clock class="w-3.5 h-3.5" />
                                <span>{{ msg.created_at }}</span>
                                <span v-if="msg.time_ago">({{ msg.time_ago }})</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex sm:flex-col items-center gap-2 shrink-0">
                            <!-- Reply via Email -->
                            <a
                                :href="`mailto:${msg.email}?subject=Re: ${encodeURIComponent(msg.subject)}`"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 text-xs font-semibold hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-colors shadow-sm"
                                title="Balas langsung ke email pengirim"
                            >
                                <Reply class="w-3.5 h-3.5" />
                                <span>Balas Email</span>
                            </a>

                            <!-- Toggle Read -->
                            <button
                                @click="toggleRead(msg.id)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
                                :title="msg.is_read ? 'Tandai sebagai belum dibaca' : 'Tandai sudah dibaca'"
                            >
                                <EyeOff v-if="msg.is_read" class="w-3.5 h-3.5" />
                                <Eye v-else class="w-3.5 h-3.5 text-emerald-500" />
                                <span>{{ msg.is_read ? 'Unread' : 'Dibaca' }}</span>
                            </button>

                            <!-- Delete -->
                            <button
                                @click="deleteMessage(msg.id)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-neutral-200 dark:border-neutral-800 text-xs font-mono text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/20 hover:border-rose-300 dark:hover:border-rose-900 transition-colors"
                                title="Hapus pesan"
                            >
                                <Trash2 class="w-3.5 h-3.5" />
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
