import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        emptyOutDir: true,
    },
    plugins: [
        laravel({
            input: ['src/css/app.css', 'src/js/app.js'],
            publicDirectory: '../public',
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['../storage/framework/views/**'],
        },
    },
});
