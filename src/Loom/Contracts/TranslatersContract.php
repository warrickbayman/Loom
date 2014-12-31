<?php
/**
 * Loom
 * 
 * @copyright   Copyright (c) 2014 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */

namespace Loom\Contracts;


/**
 * Interface TranslatersContract
 *
 * @package Loom\Contracts
 */
interface TranslatersContract
{
    /**
     * Get millseconds
     *
     * @return int
     */
    public function getMilliseconds();


    /**
     * Get seconds
     *
     * @return float
     */
    public function getSeconds();


    /**
     * Get minutes
     *
     * @return float
     */
    public function getMinutes();


    /**
     * Get hours
     *
     * @return float
     */
    public function getHours();


    /**
     * Get days
     *
     * @return float
     */
    public function getDays();


    /**
     * Get weeks
     *
     * @return float
     */
    public function getWeeks();


    /**
     * Get months
     *
     * @return float
     */
    public function getMonths();


    /**
     * Get years
     *
     * @return float
     */
    public function getYears();
}