<?php
/**
 * Loom
 * 
 * @copyright   Copyright (c) 2014 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */

namespace Loom;


/**
 * Class LoomFactory
 *
 * @package Loom
 */
class LoomFactory extends AbstractLoomFactoryContract
{
    /**
     * Create a new Loom instance
     *
     * @param AbstractUnit $unit
     *
     * @return Loom
     */
    protected function createLoom(AbstractUnit $unit)
    {
        return new Loom($unit);
    }
}