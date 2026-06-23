<?php

declare(strict_types=1);

namespace Silverorange\AmbiguousClassNameDetector;

/**
 * @copyright 2019-2026 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 *
 * @phpstan-import-type TAmbiguousClassNameDetails from Detector
 */
class Summarizer
{
    /**
     * @var string
     */
    protected $current_directory = '';

    /**
     * Creates a new summarizer.
     *
     * @param string $current_directory optional current direcory. If not
     *                                  specified, getcwd is used.
     */
    public function __construct(string $current_directory = '')
    {
        if ($current_directory === '') {
            $cwd = getcwd();
            if ($cwd === false) {
                throw new \Exception('Could not determine the current directory');
            }
            $this->current_directory = $cwd;
        } else {
            $this->current_directory = $current_directory;
        }
    }

    /**
     * Gets a human-readable summary of ambiguous class names.
     *
     * @param list<TAmbiguousClassNameDetails> $ambiguous_class_names a list of ambiguous class names
     *
     * @return string a human-readable summary of the ambiguous class names.
     *                or an empty string if there are no ambiguous class names.
     */
    public function getSummary(array $ambiguous_class_names): string
    {
        ob_start();

        foreach ($ambiguous_class_names as $matches) {
            echo '  "'
                . $matches['class_name']
                . '" in "'
                . $this->getRelativePath($matches['file1'])
                . '" and "'
                . $this->getRelativePath($matches['file2'])
                . "\"\n";
        }

        return ob_get_clean() ?: '';
    }

    /**
     * Turns an absolute path into a relative path based on the current working
     * directory.
     *
     * @param string $path the source path
     *
     * @return string a relative directory based on the current working
     *                directory. If the source path is not within the current
     *                directory it is left as an absolute path.
     */
    protected function getRelativePath(string $path): string
    {
        $prefix_expression = $this->getPrefixExpression(
            $this->current_directory
        );

        $relative_path = preg_replace($prefix_expression, '', $path);

        if ($relative_path === null) {
            throw new \Exception('Could not determine relative path (regex error)');
        }

        if ($relative_path[0] !== '/') {
            $relative_path = './' . $relative_path;
        }

        return $relative_path;
    }

    /**
     * Gets a regular expression that can be used to strip a directory prefix
     * off an absolute directory.
     *
     * @param string $directory the prefix directory to use to create the
     *                          regular expression
     *
     * @return string a regular expression used to strip the prefix from
     *                strings
     */
    protected function getPrefixExpression(string $directory): string
    {
        return '@^' . preg_quote($directory, '@') . '/@';
    }
}
