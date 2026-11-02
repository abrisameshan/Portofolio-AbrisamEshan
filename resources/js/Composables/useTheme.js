import { ref } from 'vue';

const isDark = ref(true);

export function useTheme() {
    const initTheme = () => {
        if (typeof window !== 'undefined') {
            isDark.value = document.documentElement.classList.contains('dark');
        }
    };

    const toggleTheme = () => {
        isDark.value = !isDark.value;
        if (isDark.value) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    };

    return {
        isDark,
        initTheme,
        toggleTheme,
    };
}
