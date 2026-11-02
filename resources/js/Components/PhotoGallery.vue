<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Camera, Eye, MapPin, X, ChevronLeft, ChevronRight, Sliders } from 'lucide-vue-next';

const props = defineProps({
    photos: {
        type: Array,
        required: true,
    },
});

const activeCategory = ref('All');
const selectedPhoto = ref(null);

const categories = computed(() => {
    const list = ['All'];
    props.photos.forEach(p => {
        if (!list.includes(p.category)) {
            list.push(p.category);
        }
    });
    return list;
});

const filteredPhotos = computed(() => {
    if (activeCategory.value === 'All') return props.photos;
    return props.photos.filter(p => p.category === activeCategory.value);
});

const openLightbox = (photo) => {
    selectedPhoto.value = photo;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    selectedPhoto.value = null;
    document.body.style.overflow = 'auto';
};

const nextPhoto = () => {
    if (!selectedPhoto.value) return;
    const currentIndex = filteredPhotos.value.findIndex(p => p.id === selectedPhoto.value.id);
    const nextIndex = (currentIndex + 1) % filteredPhotos.value.length;
    selectedPhoto.value = filteredPhotos.value[nextIndex];
};

const prevPhoto = () => {
    if (!selectedPhoto.value) return;
    const currentIndex = filteredPhotos.value.findIndex(p => p.id === selectedPhoto.value.id);
    const prevIndex = (currentIndex - 1 + filteredPhotos.value.length) % filteredPhotos.value.length;
    selectedPhoto.value = filteredPhotos.value[prevIndex];
};

const handleKeyDown = (e) => {
    if (!selectedPhoto.value) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') nextPhoto();
    if (e.key === 'ArrowLeft') prevPhoto();
};

onMounted(() => {
    window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeyDown);
});
</script>

<template>
    <section id="photography" class="py-20 md:py-28 relative border-t border-neutral-200 dark:border-neutral-800/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-400 font-mono text-xs tracking-wider uppercase border border-neutral-200 dark:border-neutral-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        // OPTICAL ASSETS & SHOTS
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-neutral-950 dark:text-white mt-4">
                        Galeri Fotografi
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm sm:text-base mt-2 max-w-xl">
                        Dokumentasi visual monokromatik & street candid. Klik foto untuk membuka inspektor HUD metadata EXIF.
                    </p>
                </div>

                <!-- Clean Filter Tabs -->
                <div class="flex flex-wrap items-center gap-1.5 p-1 rounded-full bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        @click="activeCategory = cat"
                        class="px-3.5 py-1.5 rounded-full text-xs font-mono transition-all duration-200"
                        :class="[
                            activeCategory === cat
                                ? 'bg-white dark:bg-neutral-800 text-neutral-950 dark:text-white font-bold shadow-sm'
                                : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-950 dark:hover:text-white'
                        ]"
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>

            <!-- Photos Grid in Clean Card Style -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="photo in filteredPhotos"
                    :key="photo.id"
                    @click="openLightbox(photo)"
                    class="group relative rounded-2xl overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 hover:border-neutral-400 dark:hover:border-neutral-600 cursor-pointer transition-all duration-300 shadow-sm flex flex-col justify-end min-h-[380px]"
                >
                    <!-- Image with smooth hover effect -->
                    <img
                        :src="photo.image_url"
                        :alt="photo.title"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 filter grayscale contrast-105 group-hover:grayscale-0 group-hover:contrast-100"
                    />

                    <!-- Clean Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent opacity-80 group-hover:opacity-85 transition-opacity"></div>

                    <!-- Top Category Tag -->
                    <div class="absolute top-4 left-4 right-4 flex items-center justify-between z-10">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-mono uppercase tracking-wider bg-black/70 backdrop-blur-md border border-white/10 text-white">
                            [ {{ photo.category }} ]
                        </span>
                        <div class="w-8 h-8 rounded-full bg-black/70 backdrop-blur-md border border-white/10 flex items-center justify-center text-neutral-300 group-hover:text-white transition-colors">
                            <Eye class="w-3.5 h-3.5" />
                        </div>
                    </div>

                    <!-- Bottom Details -->
                    <div class="relative z-10 p-5 space-y-2 text-white">
                        <div class="flex items-center gap-1.5 text-xs text-neutral-300 font-mono">
                            <MapPin class="w-3.5 h-3.5 text-neutral-400" />
                            <span>{{ photo.location }}</span>
                            <span class="text-neutral-500">·</span>
                            <span>{{ photo.year }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-white transition-colors">
                            {{ photo.title }}
                        </h3>
                        <div class="pt-2 border-t border-white/20 flex items-center justify-between text-[11px] font-mono text-neutral-300">
                            <span>{{ photo.camera }}</span>
                            <span class="text-neutral-400">{{ photo.settings }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal with EXIF Data HUD -->
        <Teleport to="body">
            <div
                v-if="selectedPhoto"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-xl p-4 md:p-8"
                @click.self="closeLightbox"
            >
                <!-- Close Button -->
                <button
                    @click="closeLightbox"
                    class="absolute top-5 right-5 z-20 p-2.5 rounded-full bg-neutral-900 border border-neutral-700 text-neutral-300 hover:text-white transition-colors"
                    aria-label="Close modal"
                >
                    <X class="w-5 h-5" />
                </button>

                <!-- Navigation Controls -->
                <button
                    @click="prevPhoto"
                    class="hidden md:flex absolute left-6 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-neutral-900/90 border border-neutral-700 text-neutral-300 hover:text-white transition-all"
                >
                    <ChevronLeft class="w-6 h-6" />
                </button>
                <button
                    @click="nextPhoto"
                    class="hidden md:flex absolute right-6 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-neutral-900/90 border border-neutral-700 text-neutral-300 hover:text-white transition-all"
                >
                    <ChevronRight class="w-6 h-6" />
                </button>

                <!-- Lightbox Card -->
                <div class="relative max-w-6xl w-full max-h-[92vh] flex flex-col lg:flex-row bg-white dark:bg-[#0c0c0e] border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden shadow-2xl">
                    <!-- Photo Canvas -->
                    <div class="flex-1 bg-black/95 flex items-center justify-center p-4 overflow-hidden min-h-[320px] lg:min-h-[500px]">
                        <img
                            :src="selectedPhoto.image_url"
                            :alt="selectedPhoto.title"
                            class="max-w-full max-h-[78vh] object-contain rounded-lg"
                        />
                    </div>

                    <!-- EXIF HUD Sidebar -->
                    <div class="w-full lg:w-96 p-6 flex flex-col justify-between bg-neutral-50 dark:bg-[#121216] border-t lg:border-t-0 lg:border-l border-neutral-200 dark:border-neutral-800 space-y-6 overflow-y-auto">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded bg-neutral-200 dark:bg-neutral-800 text-xs font-mono text-neutral-800 dark:text-neutral-300">
                                    [ {{ selectedPhoto.category }} ]
                                </span>
                                <span class="text-xs font-mono text-neutral-500">
                                    ASSET_#{{ selectedPhoto.id }}
                                </span>
                            </div>

                            <div>
                                <h3 class="text-2xl font-bold text-neutral-950 dark:text-white tracking-tight">
                                    {{ selectedPhoto.title }}
                                </h3>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 flex items-center gap-1.5 mt-1 font-mono">
                                    <MapPin class="w-3.5 h-3.5" />
                                    {{ selectedPhoto.location }} • {{ selectedPhoto.year }}
                                </p>
                            </div>

                            <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed pt-2 border-t border-neutral-200 dark:border-neutral-800">
                                {{ selectedPhoto.story }}
                            </p>
                        </div>

                        <!-- Technical EXIF HUD -->
                        <div class="space-y-3 pt-4 border-t border-neutral-200 dark:border-neutral-800">
                            <div class="flex items-center gap-2 text-xs font-mono text-neutral-600 dark:text-neutral-400 uppercase tracking-wider">
                                <Sliders class="w-3.5 h-3.5 text-indigo-500" />
                                <span>Optics & Sensor Telemetry</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs font-mono">
                                <div class="p-2.5 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                                    <span class="text-[10px] text-neutral-500 uppercase block">Camera Body</span>
                                    <span class="text-neutral-900 dark:text-neutral-200 font-semibold">{{ selectedPhoto.camera }}</span>
                                </div>
                                <div class="p-2.5 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                                    <span class="text-[10px] text-neutral-500 uppercase block">Lens Mounted</span>
                                    <span class="text-neutral-900 dark:text-neutral-200 font-semibold truncate block" :title="selectedPhoto.lens">{{ selectedPhoto.lens }}</span>
                                </div>
                                <div class="p-2.5 rounded-lg bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 col-span-2">
                                    <span class="text-[10px] text-neutral-500 uppercase block">Exposure Calibration</span>
                                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ selectedPhoto.settings }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-[10px] font-mono text-neutral-500 dark:text-neutral-400 text-center pt-2 border-t border-neutral-200 dark:border-neutral-800">
                            Use ← → keys to browse · Esc to exit
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>
    </section>
</template>
