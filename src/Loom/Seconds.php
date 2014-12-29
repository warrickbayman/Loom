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

class Seconds extends AbstractUnit
{
    /**
     * Return the seconds in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * 1000;
    }
}