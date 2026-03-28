import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import fs from 'fs';
import path from 'path';

function getCssEntries(basePath) {
    const entries = {};

    function walk(dir) {
        const files = fs.readdirSync(dir);

        for (const file of files) {
            const fullPath = path.join(dir, file);
            const relPath = path.relative(basePath, fullPath);

            if (fs.statSync(fullPath).isDirectory()) {
                walk(fullPath);
            } else if (file.endsWith('.css')) {
                // remove extension for clean naming
                const name = relPath.replace(/\.css$/, '');
                entries[name] = fullPath;
            }
        }
    }

    walk(basePath);
    return entries;
}

export default defineConfig(() => {
    const basePath = process.env.BUILD_PATH;

    if (!basePath) {
        throw new Error('BUILD_PATH not defined');
    }

    return {
        plugins: [tailwindcss()],
        build: {
            outDir: path.join(basePath, 'dist'),
            emptyOutDir: true,
            cssCodeSplit: true,
            copyPublicDir: false,
            rollupOptions: {
                input: getCssEntries(basePath),
                output: {
                    assetFileNames: '[name].css',
                }
            }
        }
    };
});