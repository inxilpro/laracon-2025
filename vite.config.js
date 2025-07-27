import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/map.js',
                'node_modules/leaflet/dist/leaflet.css',
            ],
            refresh: true,
            detectTls: 'laracon.test',
        }),
        tailwindcss(),
    ],
});
