import './bootstrap';
import Alpine from 'alpinejs';

// Theme Management
window.themeManager = {
    init() {
        // Check for saved theme preference or system preference
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },

    toggle() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        return isDark;
    },

    isDark() {
        return document.documentElement.classList.contains('dark');
    },

    setLight() {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    },

    setDark() {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
};

// Initialize theme before Alpine
window.themeManager.init();

// Alpine.js theme component
Alpine.data('themeToggle', () => ({
    isDark: window.themeManager.isDark(),

    toggle() {
        this.isDark = window.themeManager.toggle();
    }
}));

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

