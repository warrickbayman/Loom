<?php
/**
 * Loom
 * 
 * @copyright   Copyright (c) 2015 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */

namespace Loom;


use Loom\Contracts\ArithmeticContract;
use Loom\Contracts\ComparisonsContract;
use Loom\Contracts\GettersContract;
use Loom\Contracts\UnitContract;

abstract class AbstractLoom implements GettersContract, ComparisonsContract, ArithmeticContract
{
    /**
     * @var int
     */
    protected $ms = 0;


    /* -----------------------------------------------------------------------------------------------------------------
     * Getters
     * -----------------------------------------------------------------------------------------------------------------
     * Transform the Loom unit to different unit
     */


    /**
     * Get milliseconds
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
     * @param null|int $daysPerMonth
     *
     * @return float
     */
    public function getMonths($daysPerMonth = null)
    {
        return $this->ms / 1000 / 60 / 60 / 24 / (is_null($daysPerMonth) ? 365 / 12 : $daysPerMonth);
    }


    /**
     * Get years
     *
     * @param bool $solar
     *
     * @return float
     */
    public function getYears($solar = false)
    {
        $solarDays = 365.2421897;
        return $this->ms / 1000 / 60 / 60 / 24 / ($solar ? $solarDays : 365);
    }


    /* -----------------------------------------------------------------------------------------------------------------
     * Comparisons
     * -----------------------------------------------------------------------------------------------------------------
     * Equality comparisons and validators.
     */


    /**
     * Test equality
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function eq(Loom $loom)
    {
        if ($loom->getMilliseconds() == $this->ms) {
            return true;
        }
        return false;
    }


    /**
     * Test not equal to
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function ne(Loom $loom)
    {
        return ($this->ms != $loom->getMilliseconds());
    }


    /**
     * Test less than
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function lt(Loom $loom)
    {
        return ($this->ms < $loom->getMilliseconds());
    }


    /**
     * Test less than or equal to
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function lte(Loom $loom)
    {
        return ($this->ms <= $loom->getMilliseconds());
    }


    /**
     * Test greater than
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function gt(Loom $loom)
    {
        return ($this->ms > $loom->getMilliseconds());
    }


    /**
     * Test greater than or equal to
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function gte(Loom $loom)
    {
        return ($this->ms >= $loom->getMilliseconds());
    }


    /**
     * Get the difference between
     *
     * @param Loom $loom
     *
     * @return Loom
     */
    public function diff(Loom $loom)
    {
        $diff = $loom->getMilliseconds() - $this->ms;
        if ($diff < 0) {
            $diff = -$diff;
        }

        return Loom::make()->fromMilliseconds($diff);
    }


    /**
     * Is between two units
     *
     * @param Loom $start
     * @param Loom $end
     * @param bool $inclusive
     *
     * @return bool
     */
    public function isBetween(Loom $start, Loom $end, $inclusive = false)
    {
        $startMs = $start->getMilliseconds();
        $endMs = $end->getMilliseconds();

        if ($inclusive) {
            return $this->getMilliseconds() >= $startMs and $this->getMilliseconds() <= $endMs;
        }
        return $this->getMilliseconds() > $startMs and $this->getMilliseconds() < $endMs;
    }


    /* -----------------------------------------------------------------------------------------------------------------
     * Arithmetic
     * -----------------------------------------------------------------------------------------------------------------
     * Add a Loom instance, or subtract a Loom instance.
     */


    /**
     * Add a Loom
     *
     * @param Loom|AbstractUnit $loom
     *
     * @return Loom
     */
    public function add($loom)
    {
        switch (get_parent_class($loom)) {
            case 'Loom\Loom':
            case 'Loom\AbstractLoom':
                $this->ms = $this->ms + $loom->getMilliseconds();
                break;
            case 'Loom\AbstractUnit':
                $this->ms = $this->ms + $loom->toMilliseconds();
        }

        return $this;
    }


    /**
     * Subtract a Loom
     *
     * @param Loom|AbstractUnit $loom
     *
     * @return Loom
     */
    public function sub($loom)
    {
        switch(get_parent_class($loom)) {
            case 'Loom\Loom':
            case 'Loom\AbstractLoom':
                $this->ms = $this->ms - $loom->getMilliseconds();
                break;
            case 'Loom\AbstractUnit':
                $this->ms = $this->ms - $loom->toMilliseconds();
                break;
        }

        if ($this->ms < 0) {
            $this->ms = 0;
        }
        return $this;
    }


    /**
     * Get time since
     *
     * @return Loom
     */
    public function since()
    {
        $now = (new \DateTime('now'))->getTimestamp();
        $since = $this->diff(Loom::make()->fromSeconds($now));

        return $since;
    }


    /**
     * Get time until
     *
     * @return Loom
     */
    public function until()
    {
        return $this->since();
    }


    public function getRemainingDays(Loom $sub)
    {

    }
}