module.exports = {
  content: [
      './src/**/*.{vue,js,ts,jsx,tsx}',
  ],
  theme: {
      extend: {
          colors: {
              primary: {
                  500: '#2563eb',
                  600: '#1d4ed8',
                  700: '#1e40af',
              },
              secondary: {
                  500: '#10b981',
                  600: '#059669',
              },
              neutral: {
                  50: '#f9fafb',
                  100: '#f3f4f6',
                  200: '#e5e7eb',
                  800: '#1f2937',
              },
          },
          fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui'],
          },
      },
  },
  plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),
  ],
};
