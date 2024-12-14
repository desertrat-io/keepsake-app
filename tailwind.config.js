/** @type {import('tailwindcss').Config} */
import * as forms from "@tailwindcss/forms";

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.{js,ts}"
    ],
    theme: {
        extend: {},
    },
    plugins: [
        forms
    ],
}

