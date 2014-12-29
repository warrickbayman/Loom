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


use Loom\Loom;

trait LoomComparisons
{
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
}