<?php

namespace Silverorange\AmbiguousClassNameDetector;

class Summarizer
{
    protected $prefix_expressions = [];

    public function displaySummary(array $ambiguous_class_names): void
    {
        $current_directory = getcwd();

        foreach ($ambiguous_class_names as $matches) {
            echo '  "' .
                $matches['class_name'] .
                '" in "' .
                $this->getRelativeDirectory(
                    $matches['file1'],
                    $current_directory
                ) .
                '" and "' .
                $this->getRelativeDirectory(
                    $matches['file2'],
                    $current_directory
                ) .
                "\"\n";
        }
    }

    protected function getRelativeDirectory(
        string $directory,
        string $current_directory
    ): string {
        $prefix_expression = $this->getPrefixExpression($current_directory);
        $relative_directory = preg_replace($prefix_expression, '', $directory);

        if ($relative_directory[0] !== '/') {
            $relative_directory = './' . $relative_directory;
        }

        return $relative_directory;
    }

    protected function getPrefixExpression(string $directory): string
    {
        if (!isset($this->prefix_expressions[$directory])) {
            $this->prefix_expressions[$directory] =
                '@^' . preg_quote($directory, '@') . '/@';
        }

        return $this->prefix_expressions[$directory];
    }
}
