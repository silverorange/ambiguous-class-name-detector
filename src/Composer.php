<?php

declare(strict_types=1);

namespace Silverorange\AmbiguousClassNameDetector;

/**
 * @package   AmbiguousClassNameDetector
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2019 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
class Composer
{
    /**
     * Gets all output from the composer dump-autoload command
     *
     * @return string the output from composer dump-autoload.
     */
    public function getDumpAutoloadOutput(): string
    {
        $output = [];
        exec('composer --no-ansi dump-autoload 2>&1', $output);
        return implode("\n", $output) . "\n";
    }
}
