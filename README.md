Ambiguous Class Name Detector
=============================
Command-line tool to detect ambiguous class names when using the class map
autoload mechanism with Composer.

This tool is intended to be used in a CI environment to fail if ambiguous
class names are introduced in a project.

Development
-----------
These tools uses [composer](https://getcomposer.org/). To test during
development, make sure you have the required packages installed by running
`composer install`.

You can run the tool using `./bin/check-for-ambiguous-class-names`.

This project uses prettier for automatic code formatting. To format files in
the `src/` directory, run `yarn install` and then `yarn make-pretty`.

Installation
------------
Add to your project's development dependencies with:

```sh
composer require --dev silverorange/ambiguous-class-name-detector
```

Then add `composer run check-for-ambiguous-class-names` to your CI pipeline. If
ambiguous class names are detected, the command will exit with a non-zero
value and report the ambiguous class names.
