<?php

declare(strict_types=1);

namespace Silverorange\AmbiguousClassNameDetector;

/**
 * @copyright 2019-2026 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 *
 * @phpstan-type TAmbiguousClassNameDetails array{class_name: string, file1: string, file2: string}
 */
class Detector
{
    /**
     * Gets a list of ambigous class names from composer output.
     *
     * @param string $output the output from composer
     *
     * @return list<TAmbiguousClassNameDetails> if no ambiguous class
     *                                          names are detected, the array is empty
     */
    public function getAmbiguousClassNames(string $output): array
    {
        $expression
            = '/Warning: Ambiguous class resolution, '
            . '"([A-Za-z0-9_\\\]+)" was found in both '
            . '"([A-Za-z0-9.\/_-]+)" and "([A-Za-z0-9.\/_-]+)", '
            . 'the first will be used./';

        $all_matches = [];
        preg_match_all($expression, $output, $all_matches, PREG_SET_ORDER);

        return array_map(function ($matches) {
            return [
                'class_name' => $matches[1],
                'file1'      => $matches[2],
                'file2'      => $matches[3],
            ];
        }, $all_matches);
    }
}
