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
    const SOLAR_DAYS = 365.2521897;

    private $solar;


    /**
     * @param int  $value
     * @param bool $solar
     */
    public function __construct($value, $solar = false)
    {
        parent::__construct($value);

        $this->solar = $solar;
    }


    /**
     * Return the years in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * ($this->solar ? self::SOLAR_DAYS : 365) * 24 * 60 * 60 * 1000;
    }
}