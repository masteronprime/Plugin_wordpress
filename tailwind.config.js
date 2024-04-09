module.exports = {
  mode: 'jit',
  purge: [
    './**/*.html',
    './**/*.js',
  ],
  theme: {
    extend: {
    },
  },
  variants: {
    extend: {
      backgroundColor: ['hover', 'focus'],
      textColor: ['hover', 'focus'],
    },
  },
  plugins: [
  ],
}