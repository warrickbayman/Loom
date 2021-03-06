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


use Loom\Contracts\LoomFactoryInterface;

/**
 * Class AbstractLoomFactory
 *
 * @package Loom
 */
abstract class AbstractLoomFactory implements LoomFactoryInterface
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
     * Create from microseconds
     * @param float $microseconds
     *
     * @return Loom
     */
    public function fromMicroseconds($microseconds)
    {
        return $this->createLoom(new Microseconds($microseconds));
    }


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
     * Create from a DateTime object
     *
     * @param  \DateTime    $dateTime
     * @param \DateTimeZone $timeZone
     *
     * @return Loom
     * @see    AbstractLoomFactory::fromTime()
     *
     */
    public function fromDateTime(\DateTime $dateTime, \DateTimeZone $timeZone = null)
    {
        if ($timeZone) {
            $dateTime->setTimezone($timeZone);
        }
        return $this->createLoom(new Seconds($dateTime->getTimestamp()));
    }


    /**
     * Make a copy of a Loom object
     *
     * @param Loom $loom
     * @deprecated 1.1
     *
     * @return Loom
     */
    public function copy(Loom $loom)
    {
        return $this->fromLoom($loom);
    }


    /**
     * Make a copy of the Loom object
     *
     * @param Loom $loom
     *
     * @return mixed
     */
    public function fromLoom(Loom $loom)
    {
        return $this->createLoom(new Milliseconds($loom->getMilliseconds()));
    }
}
