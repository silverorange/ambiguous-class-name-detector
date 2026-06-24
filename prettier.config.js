/**
 * @see https://prettier.io/docs/en/configuration.html
 * @type {import("prettier").Config}
 */
module.exports = {
  singleQuote: true,
  tabWidth: 2,
  trailingComma: 'none',
  plugins: ['@prettier/plugin-xml'],
  overrides: [
    {
      files: '*.xml',
      options: {
        xmlQuoteAttributes: 'double',
        tabWidth: 4
      }
    }
  ]
};
