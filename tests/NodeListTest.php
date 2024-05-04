<?php
declare(strict_types=1);

namespace Meraki\Dom;

use Meraki\Dom\Node;
use Meraki\Dom\NodeList;
use Meraki\TestSuite\TestCase;

/**
 * @covers NodeList
 */
final class NodeListTest extends TestCase
{
    /**
     * @test
     */
    public function it_exists(): void
    {
        $this->assertTrue(class_exists(NodeList::class));
    }
}