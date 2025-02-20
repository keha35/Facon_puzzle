export const theme = {
  // Couleurs principales
  colors: {
    primary: {
      DEFAULT: '#2C3E50',
      light: '#34495E',
      dark: '#243342',
      100: '#E3E7EB',
      200: '#C7CFD6',
      300: '#ABB7C2',
      400: '#8F9FAD',
      500: '#738799',
      600: '#576F84',
      700: '#3B576F',
      800: '#1F3F5A',
      900: '#032745'
    },
    secondary: {
      DEFAULT: '#E74C3C',
      light: '#EC7063',
      dark: '#C0392B',
      100: '#FDEDEB',
      200: '#FBDBD7',
      300: '#F9C9C3',
      400: '#F7B7AF',
      500: '#F5A59B',
      600: '#F39387',
      700: '#F18173',
      800: '#EF6F5F',
      900: '#ED5D4B'
    },
    accent: {
      DEFAULT: '#3498DB',
      light: '#5DADE2',
      dark: '#2980B9',
      100: '#EBF5FB',
      200: '#D6EAF8',
      300: '#C2E0F4',
      400: '#AED6F1',
      500: '#9ACCED',
      600: '#86C1EA',
      700: '#72B7E6',
      800: '#5DADE2',
      900: '#49A3DF'
    },
    gray: {
      50: '#F8FAFC',
      100: '#F1F5F9',
      200: '#E2E8F0',
      300: '#CBD5E1',
      400: '#94A3B8',
      500: '#64748B',
      600: '#475569',
      700: '#334155',
      800: '#1E293B',
      900: '#0F172A'
    }
  },

  // Typographie
  typography: {
    fonts: {
      sans: ['Poppins', 'system-ui', 'sans-serif'],
      display: ['Montserrat', 'system-ui', 'sans-serif'],
      mono: ['JetBrains Mono', 'monospace']
    },
    sizes: {
      xs: '0.75rem',    // 12px
      sm: '0.875rem',   // 14px
      base: '1rem',     // 16px
      lg: '1.125rem',   // 18px
      xl: '1.25rem',    // 20px
      '2xl': '1.5rem',  // 24px
      '3xl': '1.875rem',// 30px
      '4xl': '2.25rem', // 36px
      '5xl': '3rem',    // 48px
    },
    weights: {
      light: 300,
      normal: 400,
      medium: 500,
      semibold: 600,
      bold: 700
    },
    lineHeights: {
      none: 1,
      tight: 1.25,
      snug: 1.375,
      normal: 1.5,
      relaxed: 1.625,
      loose: 2
    }
  },

  // Espacements
  spacing: {
    0: '0',
    1: '0.25rem',
    2: '0.5rem',
    3: '0.75rem',
    4: '1rem',
    5: '1.25rem',
    6: '1.5rem',
    8: '2rem',
    10: '2.5rem',
    12: '3rem',
    16: '4rem',
    20: '5rem',
    24: '6rem',
    32: '8rem'
  },

  // Breakpoints
  breakpoints: {
    sm: '640px',
    md: '768px',
    lg: '1024px',
    xl: '1280px',
    '2xl': '1536px'
  },

  // Bordures et ombres
  borders: {
    radius: {
      none: '0',
      sm: '0.125rem',
      DEFAULT: '0.25rem',
      md: '0.375rem',
      lg: '0.5rem',
      xl: '0.75rem',
      '2xl': '1rem',
      full: '9999px'
    },
    width: {
      DEFAULT: '1px',
      0: '0',
      2: '2px',
      4: '4px',
      8: '8px'
    }
  },

  // Ombres
  shadows: {
    sm: '0 1px 2px 0 rgb(0 0 0 / 0.05)',
    DEFAULT: '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
    md: '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
    lg: '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
    xl: '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)'
  },

  // Transitions
  transitions: {
    duration: {
      DEFAULT: '150ms',
      fast: '100ms',
      slow: '300ms'
    },
    timing: {
      DEFAULT: 'cubic-bezier(0.4, 0, 0.2, 1)',
      linear: 'linear',
      in: 'cubic-bezier(0.4, 0, 1, 1)',
      out: 'cubic-bezier(0, 0, 0.2, 1)',
      'in-out': 'cubic-bezier(0.4, 0, 0.2, 1)'
    }
  },

  // Z-index
  zIndex: {
    0: 0,
    10: 10,
    20: 20,
    30: 30,
    40: 40,
    50: 50,
    auto: 'auto'
  }
} 