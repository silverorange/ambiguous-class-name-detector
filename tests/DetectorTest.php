<?php

declare(strict_types=1);

namespace Silverorange\AmbiguousClassNameDetector;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @copyright 2019-2026 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 *
 * @internal
 */
#[CoversClass(Detector::class)]
final class DetectorTest extends TestCase
{
    #[Test]
    public function testReturnsEmptyArrayOnEmptyOutput(): void
    {
        $detector = new Detector();
        $this->assertEquals([], $detector->getAmbiguousClassNames(''));
    }

    #[Test]
    public function testReturnsEmptyArrayOnNonMatchingOutput(): void
    {
        $detector = new Detector();
        $this->assertEquals(
            [],
            $detector->getAmbiguousClassNames(
                "Generated autoload files containing 574 classes\n"
            )
        );
    }

    #[Test]
    public function testReturnsSingleMatch(): void
    {
        $detector = new Detector();
        $this->assertEquals(
            [
                [
                    'class_name' => 'Application',
                    'file1'      => '/foo/bar/include/Application.php',
                    'file2'      => '/foo/bar/include/Application2.php',
                ],
            ],
            $detector->getAmbiguousClassNames(
                'Generating autoload filesWarning: Ambiguous class '
                    . 'resolution, "Application" was found in both '
                    . '"/foo/bar/include/Application.php" and '
                    . '"/foo/bar/include/Application2.php", the first will '
                    . "be used.\n "
                    . "Generated autoload files containing 2906 classes\n"
            )
        );
    }

    #[Test]
    public function testReturnsNamespacedMatch(): void
    {
        $detector = new Detector();
        $this->assertEquals(
            [
                [
                    'class_name' => 'Application\Controller',
                    'file1'      => '/foo/bar/include/Application.php',
                    'file2'      => '/foo/bar/include/Application2.php',
                ],
            ],
            $detector->getAmbiguousClassNames(
                'Generating autoload filesWarning: Ambiguous class '
                    . 'resolution, "Application\Controller" was found in '
                    . 'both "/foo/bar/include/Application.php" and '
                    . '"/foo/bar/include/Application2.php", the first will '
                    . "be used.\n "
                    . "Generated autoload files containing 2906 classes\n"
            )
        );
    }

    #[Test]
    public function testReturnsMultipleMatches(): void
    {
        $detector = new Detector();
        $this->assertEquals(
            [
                [
                    'class_name' => 'Application',
                    'file1'      => '/foo/bar/include/Application.php',
                    'file2'      => '/foo/bar/include/Application2.php',
                ],
                [
                    'class_name' => 'Application',
                    'file1'      => '/foo/bar/include/Application.php',
                    'file2'      => '/foo/bar/include/Application3.php',
                ],
            ],
            $detector->getAmbiguousClassNames(
                'Generating autoload filesWarning: Ambiguous class '
                    . 'resolution, "Application" was found in both '
                    . '"/foo/bar/include/Application.php" and '
                    . '"/foo/bar/include/Application2.php", the first will '
                    . "be used.\n "
                    . 'Warning: Ambiguous class resolution, "Application" '
                    . 'was found in both "/foo/bar/include/Application.php" '
                    . 'and "/foo/bar/include/Application3.php", the first '
                    . "will be used.\n"
                    . "Generated autoload files containing 2906 classes\n"
            )
        );
    }
}
