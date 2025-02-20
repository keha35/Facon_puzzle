import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
  plugins: [vue()],
  root: './resources',
  base: '/Facon_puzzle-new/assets/',
  build: {
    outDir: '../public/assets',
    assetsDir: '',
    manifest: true,
    rollupOptions: {
      input: {
        app: './resources/js/app.js'
      }
    }
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, './resources/js'),
      '@components': resolve(__dirname, './resources/js/components'),
      '@views': resolve(__dirname, './resources/js/views'),
      '@stores': resolve(__dirname, './resources/js/stores'),
      '@assets': resolve(__dirname, './resources/assets')
    }
  },
  server: {
    strictPort: true,
    port: 5173,
    proxy: {
      '/api': {
        target: 'http://localhost/Facon_puzzle-new',
        changeOrigin: true
      }
    }
  }
}); 