<?php
declare(strict_types=1);

namespace Meraki\Dom;

use Meraki\Dom\Node;
use Meraki\TestSuite\TestCase;

/**
 * @covers Node
 */
final class NodeTest extends TestCase
{
    /**
     * @test
     */
    public function it_exists(): void
    {
        $this->assertTrue(interface_exists(Node::class));
    }
}