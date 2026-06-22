<?php

declare(strict_types=1);

namespace Silverorange\AmbiguousClassNameDetector;

/**
 * @copyright 2019-2026 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
class Runner
{
    /**
     * Creates a new runner for detecting ambiguous class names in PHP projects.
     */
    public function __construct(
        protected Composer $composer,
        protected Detector $detector,
        protected Summarizer $summarizer
    ) {}

    /**
     * Runs the application.
     */
    public function run(): void
    {
        $output = $this->composer->getDumpAutoloadOutput();
        $ambiguous_class_names = $this->detector->getAmbiguousClassNames(
            $output
        );

        // If there are no ambiguous class names detected, exit with a success
        // code.
        if (count($ambiguous_class_names) === 0) {
            exit(0);
        }

        echo "One or more ambiguous class names detected:\n\n";
        echo $this->summarizer->getSummary($ambiguous_class_names);
        echo "\n";

        exit(1);
    }
}
