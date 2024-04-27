import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'app/Livewire/**',
                'app/Filament/**',
                'resources/views/**',
                'packages/**/resources/views/**',
            ],
        }),
    ],
});
