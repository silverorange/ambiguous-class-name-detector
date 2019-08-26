<?php

namespace Silverorange\AmbiguousClassNameDetector;

/**
 * @package   AmbiguousClassNameDetector
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2019 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
class Runner
{
    /**
     * @var Silverorange\AmbiguousClassNameDetector\Composer
     */
    protected $composer = null;

    /**
     * @var Silverorange\AmbiguousClassNameDetector\Detector
     */
    protected $detector = null;

    /**
     * @var Silverorange\AmbiguousClassNameDetector\Summarizer
     */
    protected $summarizer = null;

    /**
     * Creates a new runner for detecting ambiguous class names in PHP projects
     *
     * @param Composer
     * @param Detector
     * @param Summarizer
     */
    public function __construct(
        Composer $composer,
        Detector $detector,
        Summarizer $summarizer
    ) {
        $this->composer = $composer;
        $this->detector = $detector;
        $this->summarizer = $summarizer;
    }

    /**
     * Runs the application
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
