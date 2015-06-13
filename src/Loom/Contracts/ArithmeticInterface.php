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
interface ArithmeticInterface
{
    /**
     * Add a Loom
     *
     * @param Loom|AbstractUnit $loom
     *
     * @return Loom
     */
    public function add($loom);


    /**
     * Subtract a Loom
     *
     * @param Loom|AbstractUnit $loom
     *
     * @return Loom
     */
    public function sub($loom);
}
