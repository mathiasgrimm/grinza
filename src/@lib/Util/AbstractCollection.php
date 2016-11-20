<?php namespace Grinza\Util;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;

abstract class AbstractCollection implements ArrayAccess, IteratorAggregate, Countable
{
    protected abstract function getType();
    /**
     * @var $this->getType() [] $items
     */
    protected $items = [];
    public function __construct(array $items = null)
    {
        if ($items) {
            foreach ($items as $item) {
                $this[] = $item;
            }
        }
    }
    protected function validateItem($item)
    {
        if (!is_a($item, $this->getType())) {
            throw new \InvalidArgumentException(
                'Item needs to be an array of ' . $this->getType()
            );
        }
    }
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $offset = count($this->items);
        }
        $this->validateItem($value);
        $this->items[$offset] = $value;
    }
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
    /**
     * @return array
     */
    public function items()
    {
        return $this->items;
    }
    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}