# Ambiguous Class Name Detector

Command-line tool to detect ambiguous class names when using the class 
map autoload mechanism with Composer.

This tool is intended to be used in a CI environment and should fail if
ambiguous class names are introduced in a project.

## Development

This tool uses [composer](https://getcomposer.org/). To test during
development, make sure you have the required packages installed by
running `composer install` and `pnpm install`.

You can run the tool using `./bin/check-for-ambiguous-class-names`.

This project uses [PHP-CS-Fixer](https://cs.symfony.com/) and
[Prettier](https://prettier.io/) for automatic code formatting. To
check for formatting issues in PHP and (optionally) fix them, run:

```sh
composer run phpcs
composer run phpcs:fix
```

Similarly, for non-PHP files:

```sh
pnpm format
pnpm format:fix
```

## Installation

Add to your project's development dependencies with:

```sh
composer require --dev silverorange/ambiguous-class-name-detector
```

Then add `composer run check-for-ambiguous-class-names` to your CI
pipeline. If ambiguous class names are detected, the command will exit
with a non-zero value and report the ambiguous class names.
