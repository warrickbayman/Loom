<?php


/**
 * Loom
 *
 * @copyright     Copyright (c) 2015 Warrick Bayman.
 * @author        Warrick Bayman <me@warrickbayman.co.za>
 * @license       MIT License http://opensource.org/licenses/MIT
 *
 */
class LoomRangeTest extends TestCase
{
    /** @test */
    public function it_can_create_a_range_collection()
    {
        $collection = \Loom\Loom::makeRange()
            ->from(\Loom\Loom::make()->fromMinutes(1))
            ->to(\Loom\Loom::make()->fromMinutes(5))
            ->steps(5);

        $this->assertEquals(5, $collection->count());
        $this->assertEquals(5 * 60, $collection->last()->getSeconds());

    }
}
