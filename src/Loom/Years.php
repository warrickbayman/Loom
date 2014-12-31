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
 * Class Years
 *
 * @package Loom
 */
class Years extends AbstractUnit
{
    /**
     * Return the years in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * 365 * 24 * 60 * 60 * 1000;
    }
}