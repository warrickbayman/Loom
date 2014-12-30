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

use Loom\Contracts\ComparisonsContract;
use Loom\Contracts\LoomContract;
use Loom\Contracts\TranslatersContract;
use Loom\Traits\LoomComparisons;
use Loom\Traits\LoomTranslaters;

/**
 * Class Loom
 *
 * @package Loom
 */
class Loom implements LoomContract, TranslatersContract, ComparisonsContract
{
    /**
     * @var int
     */
    private $ms = 0;

    use LoomTranslaters, LoomComparisons;

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
}