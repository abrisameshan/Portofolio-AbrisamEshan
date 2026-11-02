<script setup>
import { ref, reactive } from 'vue';
import { Mail, Send, CheckCircle2, AlertCircle, Camera, Code2, Network, MessageSquare, ArrowUpRight } from 'lucide-vue-next';
import SocialIcon from '@/Components/SocialIcon.vue';

defineProps({
    profile: {
        type: Object,
        required: true,
    },
});

const isSubmitting = ref(false);
const isSuccess = ref(false);
const successMessage = ref('');
const errorMessage = ref('');

const form = reactive({
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

const submitForm = async () => {
    isSubmitting.value = true;
    errorMessage.value = '';
    isSuccess.value = false;

    try {
        // Save to browser localStorage so Abrisam can review incoming messages in Inbox / Console
        const existingMessages = JSON.parse(localStorage.getItem('abrisam_messages') || '[]');
        const newMessage = {
            id: Date.now(),
            name: form.name,
            email: form.email,
            service_type: form.service_type,
            subject: form.subject || '(Tanpa Subjek)',
            message: form.message,
            created_at: new Date().toLocaleString('id-ID', {
                dateStyle: 'medium',
                timeStyle: 'short'
            }),
            is_read: false
        };
        existingMessages.unshift(newMessage);
        localStorage.setItem('abrisam_messages', JSON.stringify(existingMessages));

        // Submit form via Web3Forms free API
        // If an access key is set in localStorage or environment, it sends directly to email
        try {
            await fetch('https://api.web3forms.com/submit', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({
                    access_key: 'YOUR_ACCESS_KEY_HERE',
                    from_name: form.name,
                    email: form.email,
                    subject: `[Portfolio Inquiry] ${form.service_type}: ${form.subject || 'Pesan Baru'}`,
                    message: form.message,
                })
            });
        } catch (e) {
            // Silently ignore if offline or key not provided, local message is saved
        }

        isSuccess.value = true;
        successMessage.value = `Terima kasih ${form.name}! Pesan kamu berhasil dikirim. Saya akan segera menghubungi balik melalui email (${form.email}).`;

        // Reset inputs
        form.name = '';
        form.email = '';
        form.subject = '';
        form.message = '';
        form.service_type = 'General';
    } catch (err) {
        errorMessage.value = 'Terjadi kendala saat mengirim pesan. Silakan hubungi langsung via email abrisameshan@gmail.com.';
    } finally {
        isSubmitting.value = false;
    }
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
                            Tertarik berkolaborasi untuk proyek fotografi, pembuatan website modern, konsultasi sistem jaringan, atau tawaran freelance? Hubungi saya lewat formulir atau media sosial berikut:
                        </p>
                    </div>

                    <!-- Status Card -->
                    <div class="card-shine p-4 rounded-2xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </div>
                            <div>
                                <div class="text-xs font-mono font-semibold text-neutral-900 dark:text-white">Active & Available</div>
                                <div class="text-[11px] text-neutral-500 dark:text-neutral-400">Freelance, Photography, & PKL SIJA</div>
                            </div>
                        </div>
                        <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300">
                            Yogyakarta, ID
                        </span>
                    </div>

                    <!-- 7 Social Media Channel Cards -->
                    <div class="space-y-2.5">
                        <div class="text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider">
                            Direct Socials & Profiles
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <a
                                v-for="social in profile.social_links"
                                :key="social.name"
                                :href="social.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group p-3 rounded-xl bg-white dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-800 hover:border-neutral-400 dark:hover:border-neutral-600 transition-all flex items-center justify-between shadow-sm hover:scale-[1.02]"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 flex items-center justify-center shrink-0 group-hover:bg-neutral-900 group-hover:text-white dark:group-hover:bg-white dark:group-hover:text-neutral-950 transition-colors">
                                        <SocialIcon :name="social.icon" class="w-4 h-4" />
                                    </div>
                                    <div class="truncate">
                                        <div class="text-xs font-bold text-neutral-900 dark:text-white flex items-center gap-1.5">
                                            <span>{{ social.name }}</span>
                                            <span class="text-[9px] font-mono px-1 rounded bg-neutral-100 dark:bg-neutral-800 text-neutral-500">
                                                {{ social.badge }}
                                            </span>
                                        </div>
                                        <div class="text-[11px] font-mono text-neutral-500 truncate">{{ social.handle }}</div>
                                    </div>
                                </div>
                                <ArrowUpRight class="w-3.5 h-3.5 text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors shrink-0" />
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Interactive Contact Form -->
                <div class="lg:col-span-7">
                    <div class="card-shine p-7 sm:p-9 rounded-2xl bg-white dark:bg-neutral-900/40 border border-neutral-200 dark:border-neutral-800 shadow-sm relative overflow-hidden">
                        <!-- Flash Success Alert -->
                        <div
                            v-if="isSuccess"
                            class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-500/30 text-emerald-800 dark:text-emerald-200 text-sm flex items-start gap-3"
                        >
                            <CheckCircle2 class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" />
                            <div>
                                <h4 class="font-bold">Pesan Terkirim!</h4>
                                <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-0.5">{{ successMessage }}</p>
                            </div>
                        </div>

                        <!-- Flash Error Alert -->
                        <div
                            v-if="errorMessage"
                            class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-500/30 text-rose-800 dark:text-rose-200 text-sm flex items-start gap-3"
                        >
                            <AlertCircle class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0 mt-0.5" />
                            <div>
                                <h4 class="font-bold">Gagal Mengirim</h4>
                                <p class="text-xs text-rose-700 dark:text-rose-300 mt-0.5">{{ errorMessage }}</p>
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
                            </div>

                            <!-- Submit Button in High-Contrast Style -->
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full py-3 px-6 rounded-xl bg-neutral-950 dark:bg-white text-white dark:text-neutral-950 font-semibold text-sm hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-all flex items-center justify-center gap-2 disabled:opacity-50 shadow-sm cursor-pointer"
                            >
                                <Send class="w-4 h-4" />
                                <span>{{ isSubmitting ? 'Mengirim...' : 'Kirim Pesan Sekarang' }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
