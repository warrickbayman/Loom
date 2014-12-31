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
 * Interface LoomFactory
 *
 * @package Loom\Contracts
 */
interface LoomFactory
{
    /**
     * Create from milliseconds
     *
     * @param int $milliseconds
     *
     * @return Loom
     */
    public function fromMilliseconds($milliseconds);


    /**
     * Create from seconds
     *
     * @param int $seconds
     *
     * @return Loom
     */
    public function fromSeconds($seconds);


    /**
     * Create from minutes
     *
     * @param int $minutes
     *
     * @return Loom
     */
    public function fromMinutes($minutes);


    /**
     * Create from hours
     *
     * @param int $hours
     *
     * @return Loom
     */
    public function fromHours($hours);


    /**
     * Create from days
     *
     * @param int $days
     *
     * @return Loom
     */
    public function fromDays($days);


    /**
     * Create from weeks
     *
     * @param int $weeks
     *
     * @return Loom
     */
    public function fromWeeks($weeks);


    /**
     * Create from months
     *
     * @param int      $months
     * @param null|int $daysOfMonth
     *
     * @return Loom
     */
    public function fromMonths($months, $daysOfMonth = null);


    /**
     * Create from years
     *
     * @param int $years
     *
     * @return Loom
     */
    public function fromYears($years);
}