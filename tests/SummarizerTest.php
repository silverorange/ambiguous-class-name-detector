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
#[CoversClass(Summarizer::class)]
final class SummarizerTest extends TestCase
{
    #[Test]
    public function testReturnsEmptyStringOnEmptyArray(): void
    {
        $summarizer = new Summarizer();
        $this->assertEquals('', $summarizer->getSummary([]));
    }

    #[Test]
    public function testReturnsRelativePaths(): void
    {
        $summarizer = new Summarizer('/test/dir');
        $this->assertEquals(
            "  \"TestClass\" in \"./TestClass\" and \"./TestClass2\"\n"
                . "  \"FooBar\" in \"/other/dir/FooBar\" and \"/other/dir/baz/FooBar\"\n",
            $summarizer->getSummary([
                [
                    'class_name' => 'TestClass',
                    'file1'      => '/test/dir/TestClass',
                    'file2'      => '/test/dir/TestClass2',
                ],
                [
                    'class_name' => 'FooBar',
                    'file1'      => '/other/dir/FooBar',
                    'file2'      => '/other/dir/baz/FooBar',
                ],
            ])
        );
    }

    #[Test]
    public function testReturnsSingleClassName(): void
    {
        $summarizer = new Summarizer();
        $this->assertEquals(
            "  \"TestClass\" in \"/test/dir/TestClass\" and \"/test/dir/TestClass2\"\n",
            $summarizer->getSummary([
                [
                    'class_name' => 'TestClass',
                    'file1'      => '/test/dir/TestClass',
                    'file2'      => '/test/dir/TestClass2',
                ],
            ])
        );
    }
}
