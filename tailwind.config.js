const safelist =
    process.env.APP_ENV === "production"
        ? []
        : [
            {
                pattern: /^(.*?)/,
            },
        ]

/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    "./resources/js/src/*/.{vue,js,ts,tsx}",
    "./resources/*/.blade.php",
    "./resources/*/.js",
    "./resources/*/.ts",
    "./resources/*/.vue",
  ],
  safelist,
  theme: {
    extend: {},
  },
  plugins: [],
}
