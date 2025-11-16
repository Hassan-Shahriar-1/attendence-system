/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/tw-elements/dist/js/**/*.js"
  ],
  theme: {
    extend: {
      backgroundImage: {
        'radial-gradient': 'radial-gradient(123.37% 173.49% at 50% 173.49%, rgba(255, 39, 75, 1) 30.38%, rgba(255, 208, 115, 1) 62.25%, rgba(158, 143, 249, 1) 91.29%)',
        'dark-btn': 'linear-gradient(85deg, #FF274B 15.41%, #FD5674 73.93%);'
      },
      fontFamily: {
        'young-serif': "'Young Serif', serif",
        'plex': "'IBM Plex Sans', sans-serif",
        'title': "'Domine', sans-serif",
        'body': "'Libre Franklin', sans-serif",
      },
      colors: {
        'main': '#8A6FF7',
        'main-bold': '#6452D1',
        'main-light': '#DED9FA',
        'main-extralight': '#F3F1FF',
        'main-thin': '#F8F6FF',
        'main-extrathin': '#FBF9FF',
        'title': '#4E370D',
        'word': '#777C78',
        'word-medium': '#555855',
        'word-semibold': '#353735',
        'word-light' : '#9BA19C',
        'word-extralight': '#C1C8C2',
        'dark-btn': 'bg-gradient-to-r from-rose-600 to-red-400',
        'red': '#FF274B',
        'light-red': '#FD5674',
        'disabled': '#B8B3AC',
        'primary': '#2F000F',
        'primary-hover': '#600B1E',
        'secondary': '#C1E5D8',
        'secondary-hover': '#d4e8e0',
      },
      margin: {
          'header': '91px',
          'aside': '332px',
          'aside-collapsed': '114px',
      },
      width: {
          'aside': '332px',
          'aside-collapsed': '84px',
      },
      backgroundColor: {
        'header': '#FBFBF9',
        'sidebar': '#2F000F',
        'body': '#FAFAF5',
        'primary': '#2F000F',
        'primary-hover': '#600B1E',
        'secondary': '#C1E5D8',
        'secondary-hover': '#d4e8e0',
      },
    },
  },
  plugins: [
    require("tw-elements/dist/plugin.cjs"),
    // require('@tailwindcss/forms'),
  ],
}

