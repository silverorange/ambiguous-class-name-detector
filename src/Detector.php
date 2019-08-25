<?php

namespace Silverorange\AmbiguousClassNameDetector;

class Detector
{
    public function getAmbiguousClassNames(string $output): array
    {
        $expression =
            '/Warning: Ambiguous class resolution, ' .
            '"([A-Za-z0-9_]+)" was found in both ' .
            '"([A-Za-z0-9.\/_-]+)" and "([A-Za-z0-9.\/_-]+)", ' .
            'the first will be used./';

        $all_matches = [];
        preg_match_all($expression, $output, $all_matches, PREG_SET_ORDER);

        return array_map(function ($matches) {
            return [
                'class_name' => $matches[1],
                'file1' => $matches[2],
                'file2' => $matches[3]
            ];
        }, $all_matches);
    }
}
