import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import tailwindcss from "tailwindcss";
import { fileURLToPath } from "url";

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/js/dashboard.js",
        "resources/js/chunks.js",
        "resources/js/dashboard/chapter.js",
        "resources/js/dashboard/manga.js",
        "resources/js/dashboard/index.js",
        "resources/css/dropzone.css",
        "resources/js/editor.js",
        "resources/css/tom-select.css",
        "themes/default/css/app.css",
        "themes/default/js/app.js",
      ],
    }),

    {
      name: "blade",
      handleHotUpdate({ file, server }) {
        if (file.endsWith(".blade.php")) {
          server.ws.send({
            type: "full-reload",
            path: "*",
          });
        }
      },
    },
  ],
  resolve: {
    alias: {
      "@": "/themes/default/js",
    },
  },
  css: {
    postcss: {
      plugins: [
        tailwindcss({
          config: path.resolve(__dirname, "themes/default/tailwind.config.js"),
        }),
      ],
    },
  },
});
