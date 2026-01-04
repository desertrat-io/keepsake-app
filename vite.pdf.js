import {defineConfig} from 'vite';
import path from "path";

export default defineConfig({
    build: {
        copyPublicDir: false,
        outDir: path.resolve(__dirname, "./public/build/assets"),
        minify: "esbuild",
        lib: {
            entry: path.resolve(__dirname, "./resources/js/pdf.js"),
            formats: ["es"],
            rollupOptions: {
                outDir: path.resolve(__dirname, "./public/build/assets"),
            }
        },

    }
});
