<?php
declare(strict_types=1);

namespace Meraki\Dom;

use Meraki\Dom\Node;

final class NodeList implements \Countable, \IteratorAggregate
{
	private array $nodes = [];

    /**
     * Construct a new node list.
     */
	public function __construct(Node ...$nodes)
	{
		$this->nodes = $nodes;
	}

	/**
	 * Takes any number of Nodes or NodeLists and returns a new NodeList containing all the nodes.
	 */
	public static function from(Node|self $node, Node|self ...$nodes): self
	{
		$all = [];

		foreach ([$node, ...$nodes] as $node) {
			if ($node instanceof self) {
				$all = array_merge($all, $node->__toArray());
			} else {
				$all[] = $node;
			}
		}

		return new self(...$all);
	}

    /**
     * Add one or more nodes to the beginning of the list.
     */
    public function prepend(Node|self $node): self
    {
        array_unshift($this->nodes, ...self::from($node)->__toArray());

        return $this;
    }

    /**
     * Add one or more nodes to the end of the list
     */
	public function append(Node|self $node): self
	{
        array_push($this->nodes, ...self::from($node)->__toArray());

		return $this;
	}

    /**
     * Insert one or more nodes at a specific position in the list.
     */
	public function insert(int $index, Node|self $node): self
	{
		array_splice($this->nodes, $index, 0, self::from($node)->__toArray());

		return $this;
	}

    /**
     * Call a function on each node in the list.
     */
	public function forEach(callable $callback): self
	{
		foreach ($this->nodes as $node) {
			$callback($node);
		}

		return $this;
	}

    /**
     * Remove one or more nodes from the list.
     */
	public function remove(Node|self $node): self
	{
		$this->nodes = array_diff($this->nodes, self::from($node)->__toArray());

		return $this;
	}

    /**
     * Find the index of a specific node in the list.
     */
	public function indexOf(Node $node): ?int
	{
		$index = array_search($node, $this->nodes, true);

		return $index !== false ? $index : null;
	}

    /**
     * Filter and return a new list of nodes based on the criteria
     */
	public function filter(callable $criteria): self
	{
		$nodes = array_filter($this->nodes, $criteria);

		return new self(...$nodes);
	}

    /**
     * Return a subset of nodes from the list.
     */
	public function splice(int $offset, int $length = null): self
	{
		$nodes = array_splice($this->nodes, $offset, $length);

		return new self(...$nodes);
	}

    /**
     * Check if the list contains all of the nodes provided.
     */
	public function contains(Node|self $node): bool
	{
        $nodes = self::from($node)->__toArray();

		return count(array_intersect($this->nodes, $nodes)) === count($nodes);
	}

    /**
     * Remove all nodes from the list.
     */
	public function clear(): self
	{
		$this->nodes = [];

		return $this;
	}

    /**
     * Get the list as a PHP `array` type.
     */
	public function __toArray(): array
	{
		return $this->nodes;
	}

    /**
     * Check if this list is the same as another node list.
     * 
     * Both lists must have the same number of nodes, that are exactly the
     * same and also be in the same order.
     */
	public function sameAs(self $other): bool
	{
		return $this->nodes === $other->nodes;
	}

    /**
     * Check if this list is equivalent to another node list.
     * 
     * Both lists must have the same number of nodes, that are equivalent to each other
     * but can be in any order.
     */
	public function equivalentTo(self $other): bool
	{
		return $this->nodes == $other->nodes;
	}

    /**
     * Merge nodes from another list into this one.
     */
	public function merge(self $other): self
	{
		$nodes = array_merge($this->nodes, $other->__toArray());

		return new self(...$nodes);
	}

    /**
     * Count the nodes in the list.
     */
	public function count(): int
	{
		return count($this->nodes);
	}

    /**
     * Get an iterator to iterate over all the nodes.
     */
	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->nodes);
	}
}
