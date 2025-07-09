// /** @type {import('tailwindcss').Config} */
// module.exports = {
//   content: [
//     './resources/views/**/*.blade.php',
//     './resources/js/**/*.js',
//     './resources/js/**/*.vue', // jika pakai Vue
//   ],
//   theme: {
//     extend: {},
//   },
//   plugins: [],
// }
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/js/**/*.vue', // jika pakai Vue
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', 'sans-serif'], // Pastikan Figtree adalah font default
      },
      colors: {
        primary: '#FF2D20', // Merah khas Laravel
        darkGray: '#1a202c', // Warna abu-abu gelap untuk dark mode
        lightGray: '#f7fafc', // Warna abu-abu terang untuk light mode
      },
      animation: {
        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
        'fade-in': 'fadeIn 0.8s ease-out forwards',
        'slide-in-right': 'slideInRight 0.6s ease-out forwards',
        'bounce-once': 'bounceOnce 1s ease-in-out',
      },
      keyframes: {
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideInRight: {
          '0%': { transform: 'translateX(100%)', opacity: '0' },
          '100%': { transform: 'translateX(0)', opacity: '1' },
        },
        bounceOnce: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-10px)' },
        }
      },
    },
  },
  plugins: [],
}
