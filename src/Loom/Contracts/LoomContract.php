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

interface LoomContract
{
    /**
     * Get the difference between
     *
     * @param Loom $fabric
     *
     * @return Loom
     */
    public function diff(Loom $fabric);
}