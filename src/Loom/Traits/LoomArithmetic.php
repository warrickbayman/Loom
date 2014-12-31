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

trait LoomArithmetic
{
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
