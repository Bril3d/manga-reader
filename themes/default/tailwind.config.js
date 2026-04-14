import defaultTheme from "tailwindcss/defaultTheme.js";
import tailwindcssForms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./themes/default/**/*.{blade.php,js,vue,ts}",
  ],
  darkMode: "class",
  theme: {
    extend: {
      fontFamily: {
        epilogue: ["Epilogue", ...defaultTheme.fontFamily.sans],
        manrope: ["Manrope", ...defaultTheme.fontFamily.sans],
        sans: ["Manrope", ...defaultTheme.fontFamily.sans],
      },
      transitionProperty: {
        opacity: "opacity",
        backdrop: "backdrop-filter",
      },
      screens: {
        xlg: "1200px",
      },
      colors: {
        "surface": "rgb(var(--surface) / <alpha-value>)",
        "surface-variant": "rgb(var(--surface-variant) / <alpha-value>)",
        "surface-container-low": "rgb(var(--surface-container-low) / <alpha-value>)",
        "surface-container-high": "rgb(var(--surface-container-high) / <alpha-value>)",
        "surface-container-highest": "rgb(var(--surface-container-highest) / <alpha-value>)",
        "surface-container-lowest": "rgb(var(--surface-container-lowest) / <alpha-value>)",
        "neon-purple": "#d8b9ff",
        "neon-purple-deep": "#9244f4",
        "neon-pink": "#ffb2ba",
        "neon-cyan": "#18ddd9",
        "on-surface-variant": "rgb(var(--on-surface-variant) / <alpha-value>)",
        "on-surface": "rgb(var(--on-surface) / <alpha-value>)",
        "outline-variant": "rgb(var(--outline-variant) / <alpha-value>)",
        "dark-primary": "#131316",
        "dark-secondary": "#18181b",
      },
      backdropBlur: {
        xs: "2px",
      },
    },
  },

  plugins: [tailwindcssForms],
};
