module.exports = {
  root: true,
  env: {
    browser: true,
    node: true
  },
  extends: [
    "@nuxtjs/eslint-config-typescript",
    "plugin:nuxt/recommended",
    "prettier"
  ],
  plugins: [],
  // add your custom rules here
  rules: {
    "object-curly-spacing": ["error", "always"],
    "multi-word-component-names": 0
  }
};
