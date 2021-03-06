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
 * Class Minutes
 *
 * @package Loom
 */
class Minutes extends AbstractUnit
{
    /**
     * Return the minutes in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * 60 * 1000;
    }
}
