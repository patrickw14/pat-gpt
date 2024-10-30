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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    "50": "#eeefff",
                    "100": "#dddeff",
                    "200": "#bcbdff",
                    "300": "#9a9cff",
                    "400": "#797bff",
                    "500": "#575aff",
                    "600": "#4648cc",
                    "700": "#343699",
                    "800": "#232466",
                    "900": "#111233"
                }
            }
        },
    },

    plugins: [forms],
    purge: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/**/*.js',
        './resources/**/*.jsx',
    ],
};
