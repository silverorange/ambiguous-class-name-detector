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
final class SummarizerTest extends TestCase
{
    public function testReturnsEmptyStringOnEmptyArray()
    {
        $summarizer = new Summarizer();
        $this->assertEquals('', $summarizer->getSummary([]));
    }
}
