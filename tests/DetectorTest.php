<?php

declare(strict_types=1);

namespace Silverorange\AmbiguousClassNameDetector;

use PHPUnit\Framework\TestCase;

/**
 * @package   AmbiguousClassNameDetector
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2019 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
final class DetectorTest extends TestCase
{
    public function testReturnsEmptyArrayOnEmptyOutput()
    {
        $detector = new Detector();
        $this->assertEquals([], $detector->getAmbiguousClassNames(''));
    }

    public function testReturnsEmptyArrayOnNonMatchingOutput()
    {
        $detector = new Detector();
        $this->assertEquals(
            [],
            $detector->getAmbiguousClassNames(
                "Generated autoload files containing 574 classes\n"
            )
        );
    }

    public function testReturnsSingleMatch()
    {
        $detector = new Detector();
        $this->assertEquals(
            [
                [
                    'class_name' => 'Application',
                    'file1' => '/foo/bar/include/Application.php',
                    'file2' => '/foo/bar/include/Application2.php'
                ]
            ],
            $detector->getAmbiguousClassNames(
                'Generating autoload filesWarning: Ambiguous class ' .
                    "resolution, \"Application\" was found in both " .
                    "\"/foo/bar/include/Application.php\" and " .
                    "\"/foo/bar/include/Application2.php\", the first will " .
                    "be used.\n " .
                    "Generated autoload files containing 2906 classes\n"
            )
        );
    }

    public function testReturnsNamespacedMatch()
    {
        $detector = new Detector();
        $this->assertEquals(
            [
                [
                    'class_name' => 'Application\Controller',
                    'file1' => '/foo/bar/include/Application.php',
                    'file2' => '/foo/bar/include/Application2.php'
                ]
            ],
            $detector->getAmbiguousClassNames(
                'Generating autoload filesWarning: Ambiguous class ' .
                    "resolution, \"Application\\Controller\" was found in " .
                    "both \"/foo/bar/include/Application.php\" and " .
                    "\"/foo/bar/include/Application2.php\", the first will " .
                    "be used.\n " .
                    "Generated autoload files containing 2906 classes\n"
            )
        );
    }

    public function testReturnsMultipleMatches()
    {
        $detector = new Detector();
        $this->assertEquals(
            [
                [
                    'class_name' => 'Application',
                    'file1' => '/foo/bar/include/Application.php',
                    'file2' => '/foo/bar/include/Application2.php'
                ],
                [
                    'class_name' => 'Application',
                    'file1' => '/foo/bar/include/Application.php',
                    'file2' => '/foo/bar/include/Application3.php'
                ]
            ],
            $detector->getAmbiguousClassNames(
                'Generating autoload filesWarning: Ambiguous class ' .
                    "resolution, \"Application\" was found in both " .
                    "\"/foo/bar/include/Application.php\" and " .
                    "\"/foo/bar/include/Application2.php\", the first will " .
                    "be used.\n " .
                    "Warning: Ambiguous class resolution, \"Application\" " .
                    "was found in both \"/foo/bar/include/Application.php\" " .
                    "and \"/foo/bar/include/Application3.php\", the first " .
                    "will be used.\n" .
                    "Generated autoload files containing 2906 classes\n"
            )
        );
    }
}
