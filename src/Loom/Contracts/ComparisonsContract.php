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


use Loom\Loom;

interface ComparisonsContract
{
    /**
     * Test equality
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function eq(Loom $fabric);


    /**
     * Test not equal to
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function ne(Loom $fabric);


    /**
     * Test less than
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function lt(Loom $fabric);


    /**
     * Test less than or equal to
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function lte(Loom $fabric);


    /**
     * Test greater than
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function gt(Loom $fabric);


    /**
     * Test greater than or equal to
     *
     * @param Loom $fabric
     *
     * @return bool
     */
    public function gte(Loom $fabric);


    /**
     * Get the difference between
     *
     * @param Loom $fabric
     *
     * @return Loom
     */
    public function diff(Loom $fabric);


    /**
     * Is between two units
     *
     * @param Loom $start
     * @param Loom $end
     * @param bool $inclusive
     *
     * @return bool
     */
    public function isBetween(Loom $start, Loom $end, $inclusive = false);
}