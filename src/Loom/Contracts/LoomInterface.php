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
interface LoomInterface
{
    /**
     * Make a new LoomFactory instance
     *
     * @return LoomFactoryInterface
     */
    public static function make();
}
