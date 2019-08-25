<?php

namespace Silverorange\AmbiguousClassNameDetector;

class Runner
{
    protected $composer;
    protected $detector;
    protected $summarizer;

    public function __construct(
        Composer $composer,
        Detector $detector,
        Summarizer $summarizer
    ) {
        $this->composer = $composer;
        $this->detector = $detector;
        $this->summarizer = $summarizer;
    }

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
        $this->summarizer->displaySummary($ambiguous_class_names);
        echo "\n";

        exit(1);
    }
}
