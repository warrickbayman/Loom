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
 * Class Days
 *
 * @package Loom
 */
class Days extends AbstractUnit
{
    /**
     * Return the days in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * 24 * 60 * 60 * 1000;
    }
}
