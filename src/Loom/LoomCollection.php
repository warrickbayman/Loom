<?php

namespace Loom;
use Loom\Contracts\LoomCollectionInterface;

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
     * LoomCollection constructor.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->items[$item->getMilliseconds()] = $item;
        }
    }


    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }


    /**
     * Offset to retrieve
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }


    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
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
        unset($this->items[$offset]);
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
     *
     * @return LoomCollectionInterface
     */
    public function between(Loom $start, Loom $end)
    {
        return $this->filter(function(Loom $a) use ($start, $end)
        {
            return $a->isBetween($start, $end);
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
        $this->items[$loom->getMilliseconds()] = $loom;
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
            $results[$value->getMilliseconds()] = $value;
        }

        $descending ? krsort($results) : ksort($results);

        return new static($results);
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