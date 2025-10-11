import { defineConfig, loadEnv } from 'vite'

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '')
    const isDev = env.APP_ENV === 'development'

    return {
        base: isDev ? '/' : '/js/',

        build: {
            outDir: 'public/js',
            emptyOutDir: true,
            copyPublicDir: false,
            manifest: false,

            rollupOptions: {
                input: isDev
                    ? 'vite.modules.js'
                    : [
                        'vite.base.js',
                        'vite.admin.js',
                        'vite.editor.js'
                    ],

                output: {
                    entryFileNames: 'vite.[name].js',
                    chunkFileNames: 'vite.vendor.js',
                    assetFileNames: 'vite.[name].[ext]',
                },
            },
        },

        server: {
            strictPort: true,
            port: env.VITE_PORT || 5173,
            cors: true,
        },
    }
})