/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './admin/**/*.tpl.php', // Include admin templates
    './includes/**/*.php', // Include any shared templates
    './assets/js/**/*.js', // Include JS if Tailwind classes are dynamically added
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};


