import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/*.blade.php',
        './resources/views/auth/*.blade.php',
        './resources/views/components/*.blade.php',
        './resources/views/layouts/*.blade.php',
        './resources/views/profile/*.blade.php',
        './resources/views/settings/*.blade.php',
        './resources/views/tickets/*.blade.php',
        './resources/views/tasks/*.blade.php',
        './resources/views/users/*.blade.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
