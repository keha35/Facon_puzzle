/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#2C3E50',
          light: '#34495E',
          dark: '#243342'
        },
        secondary: {
          DEFAULT: '#E74C3C',
          light: '#EC7063',
          dark: '#C0392B'
        },
        accent: {
          DEFAULT: '#3498DB',
          light: '#5DADE2',
          dark: '#2980B9'
        }
      },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
        display: ['Montserrat', 'sans-serif']
      }
    }
  },
  plugins: [],
} 