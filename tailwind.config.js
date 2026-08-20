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
                display: ['"Keep Calm"', 'KeepCalm', 'Inter', ...defaultTheme.fontFamily.sans],
                heading: ['"Keep Calm"', 'KeepCalm', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#12a24a',
                    600: '#0e8a3e',
                    700: '#0b7233',
                    800: '#085a28',
                    900: '#054219',
                    950: '#022d10',
                },
            },
        },
    },

    plugins: [forms],
};
