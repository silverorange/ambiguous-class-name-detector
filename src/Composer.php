<?php

namespace Silverorange\AmbiguousClassNameDetector;

class Composer
{
    public function getDumpAutoloadOutput(): string
    {
        $output = [];
        exec('composer --no-ansi dump-autoload 2>&1', $output);
        return implode("\n", $output) . "\n";
    }
}
