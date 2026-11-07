import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Opsional: website ini memakai Tailwind lewat CDN, jadi Vite tidak wajib dijalankan.
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
