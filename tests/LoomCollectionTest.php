<?php


/**
 * Loom
 *
 * @copyright     Copyright (c) 2015 Warrick Bayman.
 * @author        Warrick Bayman <me@warrickbayman.co.za>
 * @license       MIT License http://opensource.org/licenses/MIT
 *
 */
class LoomCollectionTest extends TestCase
{
    /** @test */
    public function it_can_create_a_collection_of_looms()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2)
        ]);

        $this->assertInstanceOf(\Loom\LoomCollection::class, $collection);
    }
    
    /** @test */
    public function it_can_filter_the_collection()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2),
            \Loom\Loom::make()->fromMinutes(3),
            \Loom\Loom::make()->fromMinutes(4)
        ]);

        $result = $collection->filter(function(\Loom\Loom $loom)
        {
            return $loom->gt(\Loom\Loom::make()->fromSeconds(70));
        });

        $this->assertEquals(120, $result->first()->getSeconds());

        $after = $collection->after(\Loom\Loom::make()->fromSeconds(150));
        $this->assertEquals(3 * 60, $after->first()->getSeconds());
        $this->assertEquals(2, $after->count());

        $before = $after->before(\Loom\Loom::make()->fromMinutes(4));
        $this->assertEquals(1, $before->count());
        $this->assertEquals(3 * 60, $before->first()->getSeconds());

        $between = $collection->between(\Loom\Loom::make()->fromMinutes(2), \Loom\Loom::make()->fromMinutes(4));
        $this->assertEquals(1, $between->count());
        $this->assertEquals(3 * 60, $between->first()->getSeconds());
    }

    /** @test */
    public function it_can_run_a_callback_on_each_loom()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2),
            \Loom\Loom::make()->fromMinutes(3),
            \Loom\Loom::make()->fromMinutes(4)
        ]);

        $secondCollection = new \Loom\LoomCollection();

        $collection->each(function(Loom\Loom $loom) use ($secondCollection)
        {
            $secondCollection->push($loom->add(\Loom\Loom::make()->fromMinutes(1)));
        });

        $this->assertEquals(5 * 60, $secondCollection->last()->getSeconds());
    }

    /** @test */
    public function it_can_sort_the_collection()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2),
            \Loom\Loom::make()->fromMinutes(3),
            \Loom\Loom::make()->fromMinutes(4),
            \Loom\Loom::make()->fromMinutes(5)
        ]);

        $this->assertEquals(60, $collection->sort()->first()->getSeconds());
        $this->assertEquals(5 * 60, $collection->sort(true)->first()->getSeconds());
    }

    /** @test */
    public function it_can_get_looms_by_criteria()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2),
            \Loom\Loom::make()->fromMinutes(3),
            \Loom\Loom::make()->fromMinutes(4),
            \Loom\Loom::make()->fromMinutes(5)
        ]);

        $this->assertEquals(60, $collection->shortest()->getSeconds());
        $this->assertEquals(5 * 60, $collection->longest()->getSeconds());
    }

    /** @test */
    public function it_can_alter_the_collection()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2),
            \Loom\Loom::make()->fromMinutes(3),
            \Loom\Loom::make()->fromMinutes(4),
            \Loom\Loom::make()->fromMinutes(5)
        ]);

        $collection->prepend(\Loom\Loom::make()->fromHours(1));
        $this->assertEquals(60 * 60, $collection->first()->getSeconds());

        $hour = $collection->shift();

        $this->assertEquals(1, $hour->getHours());
        $this->assertEquals(60, $collection->first()->getSeconds());

        $collection->push(\Loom\Loom::make()->fromSeconds(30));
        $this->assertEquals(0.5, $collection->last()->getMinutes());

        $half = $collection->pop();

        $this->assertEquals(30, $half->getSeconds());
        $this->assertEquals(5, $collection->count());
    }

    /** @test */
    public function it_can_be_treated_as_an_array()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2),
            \Loom\Loom::make()->fromMinutes(3),
            \Loom\Loom::make()->fromMinutes(4),
            \Loom\Loom::make()->fromMinutes(5)
        ]);

        $this->assertEquals(3 * 60, $collection[3 * 60 * 1000]->getSeconds());
    }
}
