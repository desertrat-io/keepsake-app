import {defineConfig} from 'vite';
import path from "path";

export default defineConfig({
    build: {
        copyPublicDir: false,
        outDir: path.resolve(__dirname, "./public/build/assets"),
        minify: "esbuild",
        lib: {
            entry: path.resolve(__dirname, "./resources/js/lib/keepsake-pdf.ts"),
            formats: ["es2015"],
            rollupOptions: {
                outDir: path.resolve(__dirname, "./public/build/assets"),
            }
        },

    }
});
