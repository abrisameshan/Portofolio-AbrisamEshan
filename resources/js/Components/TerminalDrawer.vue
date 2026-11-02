<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { Terminal as TerminalIcon, X, Maximize2, Minimize2, CornerDownLeft } from 'lucide-vue-next';

defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const inputCommand = ref('');
const inputEl = ref(null);
const terminalBodyEl = ref(null);

const history = ref([
    { type: 'system', text: 'DevEnv v4.2.0-lts (x86_64-pc-linux-gnu)' },
    { type: 'system', text: 'Welcome to Abrisam\'s Portfolio Interactive CLI Shell.' },
    { type: 'info', text: 'Type "help" to view available commands or "neofetch" for system info.' },
]);

const scrollToBottom = async () => {
    await nextTick();
    if (terminalBodyEl.value) {
        terminalBodyEl.value.scrollTop = terminalBodyEl.value.scrollHeight;
    }
};

const handleCommand = () => {
    const raw = inputCommand.value.trim();
    if (!raw) return;

    history.value.push({ type: 'prompt', text: `guest@portfolio-box:~$ ${raw}` });
    const cmd = raw.toLowerCase().trim();
    inputCommand.value = '';

    if (cmd === 'clear') {
        history.value = [];
        return;
    }

    if (cmd === 'help') {
        history.value.push({
            type: 'output',
            text: `Available commands:
  help       - Menampilkan bantuan perintah ini
  whoami     - Menampilkan identitas dan profil
  socials    - Menampilkan semua akun media sosial (7 channel)
  skills     - Daftar keahlian Fotografi, Coding & Keamanan Jaringan
  neofetch   - Menampilkan ringkasan info sistem ala Linux
  projects   - Menampilkan daftar proyek unggulan
  nmap       - Simulasi scanning port & services
  cat bio    - Baca latar belakang pendidikan SIJA
  clear      - Membersihkan layar terminal
  exit       - Menutup terminal`,
        });
    } else if (cmd === 'socials' || cmd === 'contact') {
        history.value.push({
            type: 'output',
            text: `[OFFICIAL CHANNELS & SOCIAL MEDIA]
  1. Gmail     : abrisam.sija@gmail.com
  2. GitHub    : https://github.com
  3. LinkedIn  : https://linkedin.com
  4. YouTube   : https://youtube.com (@AbrisamTechVisual)
  5. Instagram : https://instagram.com (@abrisam.shots)
  6. Discord   : https://discord.com (abrisam#sija)
  7. TikTok    : https://tiktok.com (@abrisam.create)`,
        });
    } else if (cmd === 'inbox' || cmd === 'messages') {
        const msgs = JSON.parse(localStorage.getItem('abrisam_messages') || '[]');
        if (msgs.length === 0) {
            history.value.push({
                type: 'output',
                text: '[INBOX PESAN MASUK]\nBelum ada pesan yang tersimpan di browser ini.\nSilakan coba kirim pesan melalui form kontak di bagian bawah halaman!',
            });
        } else {
            let out = `[INBOX PESAN MASUK: ${msgs.length} Pesan Tersimpan]\n`;
            msgs.forEach((m, idx) => {
                out += `\n#${idx + 1} | [${m.created_at}] dari: ${m.name} <${m.email}>\nLayanan: ${m.service_type} | Subjek: ${m.subject}\nPesan: "${m.message}"\n------------------------------------------------------------`;
            });
            history.value.push({ type: 'output', text: out });
        }
    } else if (cmd === 'whoami') {
        history.value.push({
            type: 'output',
            text: 'Abrisam Daniel Kuncoro Eshan (17) | SMK Negeri 2 Depok Sleman (SIJA)\nFocus: Laravel 11, Vue 3, Network Infrastructure & Canon 60D Photography\nLocation: Sleman, D.I. Yogyakarta, Indonesia',
        });
    } else if (cmd === 'skills') {
        history.value.push({
            type: 'output',
            text: `[1] Visual & Photography (Canon EOS 60D):
    - Street, Portrait, Event, Editorial, Color Grading
    - Adobe Lightroom, Photoshop, Prime Glass (50mm f/1.8 STM)
[2] Web & Software Engineering:
    - PHP, Laravel 11, Vue.js 3, Inertia.js, Tailwind CSS
    - SQLite, MySQL, REST APIs, Git & GitHub
[3] Network & Cybersecurity (SIJA Core):
    - MikroTik RouterOS, Cisco IOS & Packet Tracer
    - Linux Ubuntu/Debian server administration
    - Wireshark packet capture, Nmap, Basic CTF writeups`,
        });
    } else if (cmd === 'neofetch') {
        history.value.push({
            type: 'output',
            text: `       /\\         abrisam@daniel-box
      /  \\        ------------------
     / /\\ \\       Name: Abrisam Daniel Kuncoro Eshan (17)
    / /__\\ \\      School: SMK Negeri 2 Depok Sleman (SIJA)
   / /    \\ \\     Core: Laravel 11 • Vue 3 • Inertia • Tailwind
  /_/      \\_\\    Location: Sleman, D.I. Yogyakarta
                  Shell: zsh 5.9
                  Camera: Canon EOS 60D (APS-C CMOS)
                  Lenses: EF 50mm f/1.8 STM · EF-S 18-55mm
                  Status: Student (17) • Available for Freelance & PKL`,
        });
    } else if (cmd === 'nmap' || cmd.startsWith('nmap ')) {
        history.value.push({
            type: 'output',
            text: `Starting Nmap 7.94 ( https://nmap.org ) at 2026-11-02 08:38 WIB
Nmap scan report for portfolio.local (127.0.0.1)
Host is up (0.00012s latency).
PORT     STATE SERVICE     VERSION
22/tcp   open  ssh         OpenSSH 9.6 (Linux)
80/tcp   open  http        Laravel / Inertia App (Vue 3)
443/tcp  open  ssl/https   TLSv1.3 Secure
8080/tcp open  http-proxy  MikroTik WebFig Lab
Scan done: 1 IP address (1 host up) scanned in 0.42 seconds.`,
        });
    } else if (cmd === 'projects') {
        history.value.push({
            type: 'output',
            text: `1. SIJA NetGuard - MikroTik RouterOS Monitoring Dashboard (Laravel + Vue)
2. LensVault - Photography Asset & Auto-EXIF Extractor
3. CTF Recon Tool - Automated Python Port & Security Probe
4. Campus VLAN Lab - Multi-VLAN Enterprise Topology with Cisco ACL`,
        });
    } else if (cmd === 'cat bio' || cmd === 'cat about') {
        history.value.push({
            type: 'output',
            text: 'Saya adalah siswa SMK jurusan SIJA yang menyukai fotografi jalanan dan potret, sekaligus antusias dalam pembuatan web interaktif dan arsitektur jaringan komputer.',
        });
    } else if (cmd === 'exit') {
        emit('close');
        return;
    } else {
        history.value.push({
            type: 'error',
            text: `zsh: command not found: ${cmd}. Ketik "help" untuk melihat perintah yang valid.`,
        });
    }

    scrollToBottom();
};

const focusInput = () => {
    if (inputEl.value) inputEl.value.focus();
};
</script>

<template>
    <Teleport to="body">
        <div
            v-if="isOpen"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-xl"
            @click.self="emit('close')"
        >
            <div
                class="w-full max-w-3xl h-[520px] bg-[#08080d] border border-white/10 rounded-2xl shadow-[0_25px_70px_rgba(0,0,0,0.85)] flex flex-col overflow-hidden font-mono text-xs card-shine"
                @click="focusInput"
            >
                <!-- Terminal Window Bar -->
                <div class="px-4 py-3 bg-[#0d0d14] border-b border-white/[0.08] flex items-center justify-between select-none">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-red-500/80 cursor-pointer" @click="emit('close')"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500/80"></span>
                        </div>
                        <span class="ml-2 text-neutral-400 text-[11px] flex items-center gap-1">
                            <TerminalIcon class="w-3.5 h-3.5 text-emerald-400" />
                            antigravity@console: ~ (zsh)
                        </span>
                    </div>

                    <div class="flex items-center gap-2 text-neutral-400">
                        <button
                            @click="emit('close')"
                            class="p-1 rounded hover:bg-white/10 hover:text-white"
                            aria-label="Close"
                        >
                            <X class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <!-- Terminal Content Output -->
                <div
                    ref="terminalBodyEl"
                    class="flex-1 p-4 overflow-y-auto space-y-2 text-neutral-200 leading-relaxed font-mono"
                >
                    <div
                        v-for="(item, index) in history"
                        :key="index"
                        :class="[
                            item.type === 'system' ? 'text-neutral-500' : '',
                            item.type === 'info' ? 'text-neutral-400' : '',
                            item.type === 'prompt' ? 'text-white font-semibold' : '',
                            item.type === 'output' ? 'text-neutral-300 whitespace-pre-wrap' : '',
                            item.type === 'error' ? 'text-rose-400' : '',
                        ]"
                    >
                        {{ item.text }}
                    </div>
                </div>

                <!-- Terminal Command Input Bar -->
                <div class="p-3 bg-[#0d0d14]/80 border-t border-white/[0.08] flex items-center gap-2">
                    <span class="text-emerald-400 font-bold">guest@portfolio-box:~$</span>
                    <input
                        ref="inputEl"
                        v-model="inputCommand"
                        @keydown.enter="handleCommand"
                        type="text"
                        placeholder="type 'help' or 'neofetch'..."
                        class="flex-1 bg-transparent border-0 outline-none text-white font-mono text-xs focus:ring-0 p-0 placeholder-neutral-600"
                        autofocus
                    />
                    <button
                        @click="handleCommand"
                        class="p-1 rounded bg-neutral-800 text-neutral-400 hover:text-white"
                        title="Execute"
                    >
                        <CornerDownLeft class="w-3.5 h-3.5" />
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>
