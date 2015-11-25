<?php

namespace Loom;

/**
 * Loom
 *
 * @copyright     Copyright (c) 2015 Warrick Bayman.
 * @author        Warrick Bayman <me@warrickbayman.co.za>
 * @license       MIT License http://opensource.org/licenses/MIT
 *
 */

class LoomRangeFactory
{
    /**
     * @var Loom
     */
    protected $from;
    /**
     * @var Loom
     */
    protected $to;

    public function from(Loom $from)
    {
        $this->from = $from;
        return $this;
    }


    public function to(Loom $to)
    {
        $this->to = $to;
        return $this;
    }


    public function steps($steps)
    {
        $diff = $this->from->diff($this->to);
        $stepSize = $diff->getMilliseconds() / ($steps -1);

        $range = new LoomCollection();
        $startingMilliseconds = $this->from->getMilliseconds();
        $endingMilliseconds = $this->to->getMilliseconds();
        for ($i = $startingMilliseconds; $i <= $endingMilliseconds; $i += $stepSize) {
            $range->push(Loom::make()->fromMilliseconds($i));
        }
        return $range;
    }
}
