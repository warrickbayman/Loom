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
 * Class Weeks
 *
 * @package Loom
 */
class Weeks extends AbstractUnit
{
    /**
     * Return the weeks in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * 7 * 24 * 60 * 60 * 1000;
    }
}
