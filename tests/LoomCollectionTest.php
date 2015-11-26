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
    private function getCollection()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2),
            \Loom\Loom::make()->fromMinutes(3),
            \Loom\Loom::make()->fromMinutes(4)
        ]);

        return $collection;
    }

    /** @test */
    public function it_can_create_a_new_collection()
    {
        $collection = new \Loom\LoomCollection([
            \Loom\Loom::make()->fromMinutes(1),
            \Loom\Loom::make()->fromMinutes(2)
        ]);

        $this->assertInstanceOf(\Loom\LoomCollection::class, $collection);
        $this->assertEquals(2, $collection->count());
    }

    /** @test */
    public function it_can_filter_the_collection()
    {
        $collection = $this->getCollection();

        $result = $collection->filter(function(\Loom\Loom $loom)
        {
            return $loom->gt(\Loom\Loom::make()->fromSeconds(120));
        });

        $this->assertEquals(3 * 60, $result->first()->getSeconds());

        $after = $collection->after(\Loom\Loom::make()->fromSeconds(3 * 60));
        $this->assertEquals(1, $after->count());
        $this->assertEquals(4 * 60, $after->first()->getSeconds());

        $before = $collection->before(\Loom\Loom::make()->fromMinutes(2));
        $this->assertEquals(1, $before->count());
        $this->assertEquals(60, $before->first()->getSeconds());

        $between = $collection->between(\Loom\Loom::make()->fromMinutes(2), \Loom\Loom::make()->fromMinutes(4));
        $this->assertEquals(1, $between->count());
        $this->assertEquals(3 * 60, $between->first()->getSeconds());

        $betweenInclusive = $collection->between(\Loom\Loom::make()->fromMinutes(2), \Loom\Loom::make()->fromMinutes(4), true);
        $this->assertEquals(3, $betweenInclusive->count());
    }

    /** @test */
    public function it_can_iterate_over_each_loom()
    {
        $collection = $this->getCollection();

        $secondCollection = new \Loom\LoomCollection();

        $collection->each(function(\Loom\Loom $loom) use ($secondCollection)
        {
            $secondCollection->push($loom->add(\Loom\Loom::make()->fromMinutes(1)));
        });

        $this->assertEquals(5 * 60, $secondCollection->last()->getSeconds());
    }

    /** @test */
    public function it_can_sort_the_collection()
    {
        $collection = $this->getCollection();

        $collection->sort(true);
        $this->assertEquals(4 * 60, $collection->first()->getSeconds());
        $collection->sort();
        $this->assertEquals(60, $collection->first()->getSeconds());
    }

    /** @test */
    public function it_can_get_specific_looms()
    {
        $collection = $this->getCollection();

        $this->assertEquals(60, $collection->shortest()->getSeconds());
        $this->assertEquals($collection->shortest()->getSeconds(), $collection->earliest()->getSeconds());
        $this->assertEquals(4 * 60, $collection->longest()->getSeconds());
        $this->assertEquals($collection->longest()->getSeconds(), $collection->latest()->getSeconds());
    }

    /** @test */
    public function it_can_alter_the_collection()
    {
        $collection = $this->getCollection();

        $collection->prepend(\Loom\Loom::make()->fromHours(1));
        $this->assertEquals(60 * 60, $collection->first()->getSeconds());

        $hour = $collection->shift();

        $this->assertEquals(1, $hour->getHours());
        $this->assertEquals(60, $collection->first()->getSeconds());

        $collection->push(\Loom\Loom::make()->fromSeconds(30));
        $this->assertEquals(0.5, $collection->last()->getMinutes());

        $half = $collection->pop();

        $this->assertEquals(30, $half->getSeconds());
        $this->assertEquals(4, $collection->count());
    }

    /** @test */
    public function it_can_be_treated_as_an_array()
    {
        $collection = $this->getCollection();

        $this->assertEquals(3 * 60, $collection[2]->getSeconds());

        $collection[] = \Loom\Loom::make()->fromMinutes(6);

        $this->assertEquals(6 * 60, $collection->last()->getSeconds());

        unset($collection[2]);

        $this->assertEquals(4 * 60, $collection[2]->getSeconds());
    }
}