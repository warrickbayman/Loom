<?php

namespace Loom;
use Loom\Contracts\LoomCollectionInterface;
use Loom\Exceptions\InvalidObjectType;

/**
 * Loom
 *
 * @copyright     Copyright (c) 2015 Warrick Bayman.
 * @author        Warrick Bayman <me@warrickbayman.co.za>
 * @license       MIT License http://opensource.org/licenses/MIT
 *
 */

class LoomCollection implements LoomCollectionInterface, \ArrayAccess, \Countable
{
    private $items = [];


    /**
     * Create a new Loom from an array of Loom objects
     *
     * @param array $items
     *
     * @throws InvalidObjectType
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            if (get_class($item) !== Loom::class) {
                throw new InvalidObjectType('LoomCollection can only contain Loom objects');
            }
            $this->items[] = $item;
        }
    }


    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset
     *
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }


    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param int $offset
     * @return Loom
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }


    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset
     * @param Loom  $value
     *
     * @throws InvalidObjectType
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($value)) {
            $this->offsetUnset($offset);
        } else {
            if (get_class($value) !== Loom::class) {
                throw new InvalidObjectType('LoomCollection can only contain Loom objects');
            }
            if (is_null($offset)) {
                $this->items[] = $value;
            } else {
                $this->items[$offset] = $value;
            }
        }
    }


    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        array_splice($this->items, $offset, 1);
    }


    /**
     * Get objects that represent dates after the specified Loom
     *
     * @param Loom $loom
     *
     * @return LoomCollectionInterface
     */
    public function after(Loom $loom)
    {
        return $this->filter(function(Loom $a) use ($loom)
        {
            return $a->gt($loom);
        });
    }


    /**
     * Get objects that represent dates before the specified Loom
     *
     * @param Loom $loom
     *
     * @return LoomCollectionInterface
     */
    public function before(Loom $loom)
    {
        return $this->filter(function(Loom $a) use ($loom)
        {
            return $a->lt($loom);
        });
    }


    /**
     * Get objects that are between the $start and $end
     *
     * @param Loom $start
     * @param Loom $end
     * @param bool $inclusive
     *
     * @return LoomCollectionInterface
     */
    public function between(Loom $start, Loom $end, $inclusive = false)
    {
        return $this->filter(function(Loom $a) use ($start, $end, $inclusive)
        {
            return $a->isBetween($start, $end, $inclusive);
        });
    }


    /**
     * Execute a callback on each Loom in the bag
     *
     * @param \Closure $callback
     *
     * @return $this
     */
    public function each(\Closure $callback)
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }


    /**
     * Get the earliest Loom object
     *
     * @return Loom
     */
    public function earliest()
    {
        return $this->shortest();
    }


    /**
     * Filter the collection
     *
     * @param \Closure $callback
     *
     * @return LoomCollectionInterface
     */
    public function filter(\Closure $callback)
    {
        return new static(array_filter($this->items, $callback));
    }


    /**
     * Get the first Loom in the collection
     *
     * @return Loom
     */
    public function first()
    {
        reset($this->items);
        return current($this->items);
    }


    /**
     * Get the latest Loom
     *
     * @return Loom
     */
    public function latest()
    {
        return $this->longest();
    }


    /**
     * Get the last loom in the collection
     *
     * @return Loom
     */
    public function last()
    {
        end($this->items);
        return current($this->items);
    }


    /**
     * Get the Loom that represents the longest amount of time
     *
     * @return Loom
     */
    public function longest()
    {
        return $this->sort()->last();
    }


    /**
     * Pop a Loom off the end of the collection
     *
     * @return Loom
     */
    public function pop()
    {
        return array_pop($this->items);
    }


    /**
     * Insert a Loom at the beginning of the collection
     *
     * @param Loom $loom
     *
     * @return mixed
     */
    public function prepend(Loom $loom)
    {
        $result = [
            $loom->getMilliseconds() => $loom
        ];
        foreach ($this->items as $key => $item) {
            $result[$key] = $item;
        }

        $this->items = $result;

        return $this;
    }


    /**
     * Push a Loom onto the end of the collection
     *
     * @param Loom $loom
     *
     * @return mixed
     */
    public function push(Loom $loom)
    {
        $this->items[] = $loom;
        return $this;
    }


    /**
     * Remove the first Loom from the collection and return it
     *
     * @return Loom
     */
    public function shift()
    {
        return array_shift($this->items);
    }


    /**
     * Get the Loom that represents the shortest amount of time
     *
     * @return Loom
     */
    public function shortest()
    {
        return $this->sort()->first();
    }


    /**
     * Sort the collection from shortest/earliest to longest/latest
     *
     * @param bool $descending
     *
     * @return LoomCollectionInterface
     */
    public function sort($descending = false)
    {
        $results = [];

        foreach ($this->items as $key => $value) {
            $results[] = $value->getMilliseconds();
        }

        $descending ? arsort($results) : asort($results);
        $sorted = [];
        foreach ($results as $index => $ms) {
            $sorted[] = Loom::make()->fromMilliseconds($ms);
        }

        $this->items = $sorted;
        return $this;
    }


    /**
     * Count elements of an object
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }
}
