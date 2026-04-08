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
        "surface": "#131316",
        "surface-variant": "#1c1c1f",
        "surface-container-low": "#1b1b1e",
        "surface-container-high": "#2a2a2d",
        "surface-container-highest": "#353438",
        "surface-container-lowest": "#0e0e11",
        "neon-purple": "#d8b9ff",
        "neon-purple-deep": "#9244f4",
        "neon-pink": "#ffb2ba",
        "neon-cyan": "#18ddd9",
        "on-surface-variant": "#cac3d8",
        "on-surface": "#e4e1e6",
        "outline-variant": "#2d2c33", // Updated to hex for better modifier support
        "dark-primary": "#131316", // Updating existing for compatibility
      },
      backdropBlur: {
        xs: "2px",
      },
    },
  },

  plugins: [tailwindcssForms],
};
