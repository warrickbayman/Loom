<?php namespace Loom; 
/**
 * Loom
 * 
 * @copyright   Copyright (c) 2015 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */
 
class Microseconds extends AbstractUnit
{
    /**
     * Return the value in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value / 1000;
    }
}