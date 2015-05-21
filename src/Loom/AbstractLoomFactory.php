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


use Loom\Contracts\LoomFactoryContract;

/**
 * Class AbstractLoomFactory
 *
 * @package Loom
 */
abstract class AbstractLoomFactory implements LoomFactoryContract
{
    /**
     * Create a new Loom instance
     *
     * @param AbstractUnit $unit
     *
     * @return Loom
     */
    abstract protected function createLoom(AbstractUnit $unit);


    /**
     * Create from milliseconds
     *
     * @param int $milliseconds
     *
     * @return Loom
     */
    public function fromMilliseconds($milliseconds)
    {
        return $this->createLoom(new Milliseconds($milliseconds));
    }


    /**
     * Create from seconds
     *
     * @param int $seconds
     *
     * @return Loom
     */
    public function fromSeconds($seconds)
    {
        return $this->createLoom(new Seconds($seconds));
    }


    /**
     * Create from minutes
     *
     * @param int $minutes
     *
     * @return Loom
     */
    public function fromMinutes($minutes)
    {
        return $this->createLoom(new Minutes($minutes));
    }


    /**
     * Create from hours
     *
     * @param int $hours
     *
     * @return Loom
     */
    public function fromHours($hours)
    {
        return $this->createLoom(new Hours($hours));
    }


    /**
     * Create from days
     *
     * @param int $days
     *
     * @return Loom
     */
    public function fromDays($days)
    {
        return $this->createLoom(new Days($days));
    }


    /**
     * Create from weeks
     *
     * @param int $weeks
     *
     * @return Loom
     */
    public function fromWeeks($weeks)
    {
        return $this->createLoom(new Weeks($weeks));
    }


    /**
     * Create from months
     *
     * @param int      $months
     * @param null|int $daysOfMonth
     *
     * @return Loom
     */
    public function fromMonths($months, $daysOfMonth = null)
    {
        return $this->createLoom(new Months($months, $daysOfMonth));
    }


    /**
     * Create from years
     *
     * @param int  $years
     * @param bool $solar
     *
     * @return Loom
     */
    public function fromYears($years, $solar = false)
    {
        return $this->createLoom(new Years($years, $solar));
    }


    /**
     * Create from a new DateTime object
     *
     * @deprecated 0.3 Replaced by fromDateTime()
     * @see        AbstractLoomFactory::fromDateTime()
     * @param      \DateTime $dateTime
     *
     * @return Loom
     */
    public function fromTime(\DateTime $dateTime)
    {
        return $this->createLoom(new Seconds($dateTime->getTimestamp()));
    }


    /**
     * Create from a DateTime object
     *
     * @param  \DateTime $dateTime
     * @see    AbstractLoomFactory::fromTime()
     *
     * @return Loom
     */
    public function fromDateTime(\DateTime $dateTime)
    {
        return $this->createLoom(new Seconds($dateTime->getTimestamp()));
    }
}