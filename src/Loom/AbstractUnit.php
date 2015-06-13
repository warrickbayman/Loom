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

use Loom\Contracts\UnitInterface;

/**
 * Class AbstractUnit
 *
 * @package Loom
 */
abstract class AbstractUnit implements UnitInterface
{
    /**
     * @var int
     */
    protected $value = 0;


    /**
     * @param int $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }


    /**
     * Return the value in milliseconds
     *
     * @return int
     */
    abstract public function toMilliseconds();
}
