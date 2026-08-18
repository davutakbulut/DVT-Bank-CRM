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
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            letterSpacing: {
                tightest: '-0.035em',
                tighter: '-0.025em',
                tight: '-0.015em',
            },
            borderRadius: {
                'none': '0px',
                'sm': '4px',
                'DEFAULT': '6px',
                'md': '8px',
                'lg': '10px',
                'xl': '12px',
                '2xl': '14px',
                '3xl': '16px',
            },
        },
    },

    plugins: [forms],
};
