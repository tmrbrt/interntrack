import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Keep this if you also use app.css
                'resources/css/style.css', // Add style.css here
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
