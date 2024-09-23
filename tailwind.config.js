/** @type {import('tailwindcss').Config} */
const purgecss = require('@fullhuman/postcss-purgecss')
module.exports = {
  content: [
      './*.{html,php}',
      './partials/**/*.{html,php}',
      './libs/**/*.{html,php}',
      './views/**/*.{html,php}',
      './assets/**/*.js',
  ],
    important: true,
  theme: {
    extend: {},
  },
    plugins: [
        purgecss({
            content: ['./**/*.php']
        })
    ]
}

