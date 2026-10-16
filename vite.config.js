import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import statamic from '@statamic/cms/vite-plugin';

export default defineConfig({
    plugins: [
        statamic(),
        laravel({
            input: ['resources/js/cp.js'],
            publicDirectory: 'resources/dist',
            buildDirectory: 'build',
            hotFile: 'resources/dist/hot',
            refresh: true,
            detectTls: 'blijkconnect.test',
        }),
    ],
    build: {
        emptyOutDir: true,
        manifest: 'manifest.json',
        outDir: 'resources/dist/build',
    },
    server: {
        cors: true,
        strictPort: true,
    },
});
