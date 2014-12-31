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
 * Interface LoomContract
 *
 * @package Loom\Contracts
 */
interface LoomContract
{
    /**
     * Make a new LoomFactory instance
     *
     * @return LoomFactory
     */
    public static function make();
}