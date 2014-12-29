<?php
/**
 * Loom
 * 
 * @copyright   Copyright (c) 2014 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */

namespace Loom\Traits;


/**
 * Class LoomTranslaters
 *
 * @package Loom\Traits
 */
trait LoomTranslaters
{
    /**
     * Get millseconds
     *
     * @return int
     */
    public function getMilliseconds()
    {
        return $this->ms;
    }


    /**
     * Get seconds
     *
     * @return float
     */
    public function getSeconds()
    {
        return $this->ms / 1000;
    }


    /**
     * Get minutes
     *
     * @return float
     */
    public function getMinutes()
    {
        return $this->ms / 1000 / 60;
    }


    /**
     * Get hours
     *
     * @return float
     */
    public function getHours()
    {
        return $this->ms / 1000 / 60 / 60;
    }


    /**
     * Get days
     *
     * @return float
     */
    public function getDays()
    {
        return $this->ms / 1000 / 60 / 60 / 24;
    }


    /**
     * Get weeks
     *
     * @return float
     */
    public function getWeeks()
    {
        return $this->ms / 1000 / 60 / 60 / 24 / 7;
    }


    /**
     * Get months
     *
     * @return float
     */
    public function getMonths()
    {
        return $this->ms / 1000 / 60 / 60 / 24 / (365 / 12);
    }


    /**
     * Get years
     *
     * @return float
     */
    public function getYears()
    {
        return $this->ms / 1000 / 60 / 60 / 24 / 365;
    }
}