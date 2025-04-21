import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true
        }),
    ],
    server: {
        cors: {
            origin: /https?:\/\/([A-Za-z0-9-.]+)?(localhost|\.local)(?::\d+)?$/
        }
    }
});
