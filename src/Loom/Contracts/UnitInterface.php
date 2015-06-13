<?php
/**
 * Loom
 * 
 * @copyright   Copyright (c) 2014 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */

namespace Loom\Contracts;

/**
 * Interface UnitContract
 *
 * @package Loom\Contracts
 */
interface UnitInterface
{
    /**
     * Return the value in milliseconds
     *
     * @return int
     */
    public function toMilliseconds();
}
