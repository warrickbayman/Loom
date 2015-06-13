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

interface ComparisonsInterface
{
    /**
     * Test equality
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function eq(Loom $loom);


    /**
     * Test not equal to
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function ne(Loom $loom);


    /**
     * Test less than
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function lt(Loom $loom);


    /**
     * Test less than or equal to
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function lte(Loom $loom);


    /**
     * Test greater than
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function gt(Loom $loom);


    /**
     * Test greater than or equal to
     *
     * @param Loom $loom
     *
     * @return bool
     */
    public function gte(Loom $loom);


    /**
     * Get the difference between
     *
     * @param Loom $loom
     *
     * @return Loom
     */
    public function diff(Loom $loom);


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
