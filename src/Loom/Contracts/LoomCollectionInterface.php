<?php

namespace Loom\Contracts;
use Loom\Loom;

/**
 * Loom
 *
 * @copyright     Copyright (c) 2015 Warrick Bayman.
 * @author        Warrick Bayman <me@warrickbayman.co.za>
 * @license       MIT License http://opensource.org/licenses/MIT
 *
 */

interface LoomCollectionInterface
{
    /**
     * Get objects that represent dates after the specified Loom
     *
     * @param Loom $loom
     *
     * @return LoomCollectionInterface
     */
    public function after(Loom $loom);


    /**
     * Get objects that represent dates before the specified Loom
     *
     * @param Loom $loom
     *
     * @return LoomCollectionInterface
     */
    public function before(Loom $loom);


    /**
     * Get objects that are between the $start and $end
     *
     * @param Loom $start
     * @param Loom $end
     *
     * @return LoomCollectionInterface
     */
    public function between(Loom $start, Loom $end);


    /**
     * Execute a callback on each Loom in the bag
     *
     * @param \Closure $callback
     *
     * @return LoomCollectionInterface
     */
    public function each(\Closure $callback);


    /**
     * Get the earliest Loom object
     *
     * @return Loom
     */
    public function earliest();


    /**
     * Filter the collection
     *
     * @param \Closure $callback
     *
     * @return LoomCollectionInterface
     */
    public function filter(\Closure $callback);


    /**
     * Get the first Loom in the collection
     *
     * @return Loom
     */
    public function first();


    /**
     * Get the latest Loom
     *
     * @return Loom
     */
    public function latest();


    /**
     * Get the last loom in the collection
     *
     * @return Loom
     */
    public function last();


    /**
     * Get the Loom that represents the longest amount of time
     *
     * @return Loom
     */
    public function longest();


    /**
     * Pop a Loom off the end of the collection
     *
     * @return Loom
     */
    public function pop();


    /**
     * Insert a Loom at the beginning of the collection
     *
     * @param Loom $loom
     *
     * @return mixed
     */
    public function prepend(Loom $loom);


    /**
     * Push a Loom onto the end of the collection
     *
     * @param Loom $loom
     *
     * @return mixed
     */
    public function push(Loom $loom);


    /**
     * Remove the first Loom from the collection and return it
     *
     * @return Loom
     */
    public function shift();


    /**
     * Get the Loom that represents the shortest amount of time
     *
     * @return Loom
     */
    public function shortest();


    /**
     * Sort the collection from shortest/earliest to longest/latest
     *
     * @param bool $descending
     *
     * @return
     */
    public function sort($descending = false);
}
