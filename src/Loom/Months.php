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


class Months extends AbstractUnit
{
    /**
     * Return the months in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * (365 / 12) * 24 * 60 * 60 * 1000;
    }
}