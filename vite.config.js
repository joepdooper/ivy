import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        manifest: true,
        outDir: 'public/dist',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                modules: 'public/js/vite.modules.js',
            }
        }
    }
});
