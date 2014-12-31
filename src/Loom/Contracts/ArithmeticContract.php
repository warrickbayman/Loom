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


use Loom\Loom;

/**
 * Interface ArithmeticContract
 *
 * @package Loom\Contracts
 */
interface ArithmeticContract
{
    /**
     * Add a Loom
     *
     * @param Loom $loom
     *
     * @return Loom
     */
    public function add(Loom $loom);


    /**
     * Subtract a Loom
     *
     * @param Loom $loom
     *
     * @return Loom
     */
    public function sub(Loom $loom);
}