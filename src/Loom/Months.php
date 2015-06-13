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


/**
 * Class Months
 *
 * @package Loom
 */
class Months extends AbstractUnit
{
    /**
     * @var null
     */
    private $daysPerMonth = null;


    /**
     * @param int      $value
     * @param int|null $daysPerMonth
     */
    public function __construct($value, $daysPerMonth = null)
    {
        parent::__construct($value);

        $this->daysPerMonth = $daysPerMonth;
    }


    /**
     * Return the months in milliseconds
     *
     * @return int
     */
    public function toMilliseconds()
    {
        return $this->value * (is_null($this->daysPerMonth) ? 365 / 12 : $this->daysPerMonth) * 24 * 60 * 60 * 1000;
    }
}
