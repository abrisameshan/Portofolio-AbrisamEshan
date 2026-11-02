<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { Mail, Send, CheckCircle2, AlertCircle, Camera, Code2, Network, MessageSquare, ArrowUpRight } from 'lucide-vue-next';
import SocialIcon from '@/Components/SocialIcon.vue';

defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const page = usePage();

const form = useForm({
    name: '',
    email: '',
    service_type: 'General',
    subject: '',
    message: '',
});

const serviceOptions = [
    { id: 'General', label: 'General / Chat', icon: MessageSquare },
    { id: 'Photography', label: 'Photography / Event', icon: Camera },
    { id: 'Web Development', label: 'Laravel / Vue Project', icon: Code2 },
    { id: 'Network & IT', label: 'Network & Lab Setup', icon: Network },
];

const submitForm = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <section id="contact" class="py-20 md:py-28 relative border-t border-neutral-200 dark:border-neutral-800/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Info & 7 Social Media Channels -->
                <div class="lg:col-span-5 space-y-8">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-400 font-mono text-xs tracking-wider uppercase border border-neutral-200 dark:border-neutral-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            // CONNECT & CHANNELS
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-neutral-950 dark:text-white mt-4">
                            Mari Terhubung & Berkolaborasi
                        </h2>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm sm:text-base mt-3 leading-relaxed">
                            Tertarik berkolaborasi untuk proyek fotografi, pembuatan website fullstack (Laravel + Vue), konsultasi sistem jaringan, atau tawaran freelance? Hubungi saya lewat formulir atau media sosial berikut:
                        </p>
                    </div>

                    <!-- Status Card -->
                    <div class="card-shine p-4 rounded-2xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800 flex items-center justify-between shadow-sm">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-xs font-mono uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Status Ketersediaan</span>
                            </div>
                            <div class="text-sm font-semibold text-neutral-950 dark:text-white">{{ profile.status }}</div>
                            <div class="text-xs text-neutral-500 dark:text-neutral-400 font-mono">
                                Lokasi: {{ profile.location }}
                            </div>
                        </div>
                    </div>

                    <!-- 7 Social Media Channels Grid -->
                    <div class="space-y-2.5">
                        <div class="text-xs font-mono text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2 flex items-center justify-between">
                            <span>Official Social Channels (7)</span>
                            <span class="text-neutral-400 dark:text-neutral-500 font-normal">Click to connect</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2">
                            <a
                                v-for="social in profile.social_links"
                                :key="social.name"
                                :href="social.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="card-shine group p-3 rounded-xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800 hover:border-neutral-400 dark:hover:border-neutral-600 transition-all flex items-center justify-between shadow-sm"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center text-neutral-700 dark:text-neutral-300 group-hover:text-neutral-950 dark:group-hover:text-white transition-colors shrink-0">
                                        <SocialIcon :name="social.icon" class-name="w-4 h-4" />
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-neutral-950 dark:text-white">{{ social.name }}</span>
                                            <span class="px-1.5 py-0.2 rounded text-[9px] font-mono bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-700">
                                                {{ social.badge }}
                                            </span>
                                        </div>
                                        <span class="text-[11px] font-mono text-neutral-500 dark:text-neutral-400 truncate block">
                                            {{ social.handle }}
                                        </span>
                                    </div>
                                </div>

                                <div class="w-7 h-7 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center text-neutral-400 group-hover:text-neutral-950 dark:group-hover:text-white transition-colors shrink-0">
                                    <ArrowUpRight class="w-3.5 h-3.5" />
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Contact Form in Clean Style -->
                <div class="lg:col-span-7">
                    <div class="card-shine p-7 sm:p-9 rounded-2xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800 shadow-sm relative overflow-hidden">
                        <!-- Flash Success Alert -->
                        <div
                            v-if="page.props.flash?.success"
                            class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-500/30 text-emerald-800 dark:text-emerald-200 text-sm flex items-start gap-3"
                        >
                            <CheckCircle2 class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" />
                            <div>
                                <h4 class="font-bold">Pesan Terkirim!</h4>
                                <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-0.5">{{ page.props.flash.success }}</p>
                            </div>
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-6">
                            <!-- Service Type Selection -->
                            <div>
                                <label class="block text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider mb-2.5">
                                    Topik / Layanan
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    <button
                                        v-for="opt in serviceOptions"
                                        :key="opt.id"
                                        type="button"
                                        @click="form.service_type = opt.id"
                                        class="p-2.5 rounded-xl border text-left transition-all flex flex-col justify-between"
                                        :class="[
                                            form.service_type === opt.id
                                                ? 'bg-neutral-900 dark:bg-white text-white dark:text-neutral-950 border-neutral-900 dark:border-white shadow-sm'
                                                : 'bg-neutral-50 dark:bg-neutral-950/60 border-neutral-200 dark:border-neutral-800 text-neutral-600 dark:text-neutral-400 hover:border-neutral-300 dark:hover:border-neutral-700'
                                        ]"
                                    >
                                        <component :is="opt.icon" class="w-4 h-4 mb-2" />
                                        <span class="text-xs font-medium">{{ opt.label }}</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Name & Email Inputs -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider mb-1.5">
                                        Nama Anda *
                                    </label>
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        required
                                        placeholder="cth. Budi Pratama"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-sm text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:border-neutral-400 dark:focus:border-neutral-600 transition-colors"
                                    />
                                    <span v-if="form.errors.name" class="text-xs text-rose-500 mt-1 block">
                                        {{ form.errors.name }}
                                    </span>
                                </div>

                                <div>
                                    <label for="email" class="block text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider mb-1.5">
                                        Email Anda *
                                    </label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        placeholder="budi@example.com"
                                        class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-sm text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:border-neutral-400 dark:focus:border-neutral-600 transition-colors"
                                    />
                                    <span v-if="form.errors.email" class="text-xs text-rose-500 mt-1 block">
                                        {{ form.errors.email }}
                                    </span>
                                </div>
                            </div>

                            <!-- Subject Input -->
                            <div>
                                <label for="subject" class="block text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider mb-1.5">
                                    Subjek Pesan (Opsional)
                                </label>
                                <input
                                    id="subject"
                                    v-model="form.subject"
                                    type="text"
                                    placeholder="cth. Penawaran Project Web / Sesi Foto Wisuda"
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-sm text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:border-neutral-400 dark:focus:border-neutral-600 transition-colors"
                                />
                            </div>

                            <!-- Message Input -->
                            <div>
                                <label for="message" class="block text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider mb-1.5">
                                    Pesan / Deskripsi Proyek *
                                </label>
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    rows="4"
                                    required
                                    placeholder="Ceritakan detail proyek atau pertanyaan kamu..."
                                    class="w-full px-3.5 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 text-sm text-neutral-900 dark:text-white placeholder-neutral-400 dark:placeholder-neutral-600 focus:outline-none focus:border-neutral-400 dark:focus:border-neutral-600 transition-colors resize-none"
                                ></textarea>
                                <span v-if="form.errors.message" class="text-xs text-rose-500 mt-1 block">
                                    {{ form.errors.message }}
                                </span>
                            </div>

                            <!-- Submit Button in High-Contrast Style -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full py-3 px-6 rounded-xl bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 font-semibold text-sm hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-all flex items-center justify-center gap-2 disabled:opacity-50 shadow-sm"
                            >
                                <Send class="w-4 h-4" />
                                <span>{{ form.processing ? 'Mengirim...' : 'Kirim Pesan Sekarang' }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
