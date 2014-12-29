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

class Hours extends AbstractUnit
{
    /**
     * Return the hours in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * 60 * 60 * 1000;
    }
}