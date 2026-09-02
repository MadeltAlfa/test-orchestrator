import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                // 1. Warna Utama (Brand - Hijau)
                "primary": "#2C3E28",
                "primary-container": "#E4EDDF",
                "on-primary-container": "#2C3E28",
                "primary-fixed": "#D2DFCE",
                "primary-fixed-dim": "#A4BCA0",
                "inverse-primary": "#4A6741",
                "on-primary": "#ffffff",

                // 2. Warna Surface / Background (Cream)
                "background": "#F5F0E8",
                "surface": "#F5F0E8",
                "surface-bright": "#FDFAF5",
                "surface-container-lowest": "#ffffff",
                "surface-container-low": "#EDE7D8",
                "surface-container": "#E4DDD0",
                "surface-container-high": "#D9D2C3",
                "surface-dim": "#CFC7B5",
                "surface-variant": "#E4DDD0",
                "on-surface": "#1A1614",
                "on-background": "#1A1614",
                "on-surface-variant": "rgba(26, 22, 20, 0.65)",

                // 3. Warna Aksen / Status
                "secondary": "#4A6741",
                "secondary-container": "#E4EDDF",
                "on-secondary-container": "#2C3E28",
                "secondary-fixed-dim": "#A4BCA0",
                "on-secondary": "#ffffff",

                "tertiary": "#9B7A18",
                "tertiary-container": "#F4E3B1",
                "tertiary-fixed-dim": "#CBB26A",
                "on-tertiary": "#ffffff",

                "error": "#B83A2A",
                "error-container": "#FADBD8",
                "on-error-container": "#78281F",
                "on-error": "#ffffff",

                // Outlines & Other system colors (aligned to ink shades)
                "outline": "rgba(26, 22, 20, 0.18)",
                "outline-variant": "rgba(26, 22, 20, 0.08)",
                "surface-tint": "#2C3E28",
                "inverse-surface": "#1A1614",
                "inverse-on-surface": "#F5F0E8"
            },
            fontFamily: {
                "headline": ["Source Serif 4", "Georgia", "serif"],
                "body": ["DM Sans", "sans-serif"],
                "label": ["DM Mono", "monospace"]
            },
        },
    },

    plugins: [forms],
};
