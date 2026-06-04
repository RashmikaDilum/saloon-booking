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
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Cormorant Garamond', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                cream: {
                    50: '#050505',  // Deepest black background
                    100: '#0A0A0A', // Slightly lifted black for panels
                    200: '#1A1A1A', // Borders and subtle highlights
                    900: '#F3E5AB', // Light gold for text that used to be dark cream
                },
                charcoal: {
                    50: '#111111',  // Very dark grey for elements
                    100: '#1A1A1A',
                    700: '#B08D55', // Muted dark gold
                    800: '#E8C965', // Bright hover gold
                    900: '#D4AF37', // Elegant primary metallic gold
                }
            }
        },
    },

    plugins: [forms],
};
