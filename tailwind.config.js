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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                heading: ['"Outfit"', '"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                display: ['"Outfit"', '"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            letterSpacing: {
                tightest: '-0.035em',
                tighter: '-0.025em',
                tight: '-0.015em',
            },
            // Vercel / Linear / Stripe Enterprise Precision Radiuses (Anti-Slop)
            borderRadius: {
                'none': '0px',
                'sm': '2px',
                'DEFAULT': '4px',
                'md': '6px',
                'lg': '8px',
                'xl': '10px',
                '2xl': '12px',
                '3xl': '14px',
                'full': '9999px',
            },
        },
    },

    plugins: [forms],
};
