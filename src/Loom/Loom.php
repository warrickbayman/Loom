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

use Loom\Contracts\LoomInterface;

/**
 * Class Loom
 *
 * @package Loom
 */
class Loom extends AbstractLoom implements LoomInterface
{
    /**
     * Loom
     *
     * @param AbstractUnit $unit
     */
    public function __construct(AbstractUnit $unit)
    {
        $this->ms = $unit->toMilliseconds();
    }


    /**
     * Make a new LoomFactory instance
     *
     * @return LoomFactory
     */
    public static function make()
    {
        return new LoomFactory();
    }


    public static function makeRange()
    {
        return new LoomRangeFactory();
    }
}
