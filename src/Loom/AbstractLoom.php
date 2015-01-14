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
     * @param Loom $fabric
     *
     * @return bool
     */
    public function eq(Loom $fabric)
    {
        if ($fabric->getMilliseconds() == $this->ms) {
            return true;
        }
        return false;
    }


    /**
     * Test not equal to
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function ne(Loom $fabric)
    {
        return ($this->ms != $fabric->getMilliseconds());
    }


    /**
     * Test less than
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function lt(Loom $fabric)
    {
        return ($this->ms < $fabric->getMilliseconds());
    }


    /**
     * Test less than or equal to
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function lte(Loom $fabric)
    {
        return ($this->ms <= $fabric->getMilliseconds());
    }


    /**
     * Test greater than
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function gt(Loom $fabric)
    {
        return ($this->ms > $fabric->getMilliseconds());
    }


    /**
     * Test greater than or equal to
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function gte(Loom $fabric)
    {
        return ($this->ms >= $fabric->getMilliseconds());
    }


    /**
     * Get the difference between
     *
     * @param Loom $fabric
     *
     * @return Loom
     */
    public function diff(Loom $fabric)
    {
        $diff = $fabric->getMilliseconds() - $this->ms;
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
     * @param Loom $loom
     *
     * @return Loom
     */
    public function add(Loom $loom)
    {
        $this->ms = $this->ms + $loom->getMilliseconds();
        return $this;
    }


    /**
     * Subtract a Loom
     *
     * @param Loom $loom
     *
     * @return Loom
     */
    public function sub(Loom $loom)
    {
        $this->ms = $this->ms - $loom->getMilliseconds();
        if ($this->ms < 0) {
            $this->ms = 0;
        }
        return $this;
    }
}