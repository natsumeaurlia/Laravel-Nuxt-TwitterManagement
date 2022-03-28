module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
  },
  extends: [
    '@nuxtjs/eslint-config-typescript',
    'plugin:nuxt/recommended',
    'prettier',
  ],
  plugins: [],
  // add your custom rules here
  rules: {
    'object-curly-spacing': ['error', 'always'],
    'vue/multi-word-component-names': 'off',
    'vue/require-default-prop': 'off',
    'no-useless-constructor': 'off',
    'import/named': 'off',
    'symbol-description': 'off',
    'vue/valid-v-slot': ['error', {
      allowModifiers: true,
    }],
  },
}
