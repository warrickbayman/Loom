<?php

/**
 * Loom
 * 
 * @copyright   Copyright (c) 2014 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */

use Loom\Loom;

class FabricTest extends TestCase
{
    /** @test */
    public function it_can_translate_values()
    {
        $loom = new Loom(new \Loom\Seconds(60));

        $this->assertEquals(60000, $loom->getMilliseconds());
        $this->assertEquals(60, $loom->getSeconds());
        $this->assertEquals(1, $loom->getMinutes());

        $loom = new Loom(new \Loom\Hours(24));
        $this->assertEquals(1, $loom->getDays());
        $this->assertEquals((1 / 7), $loom->getWeeks());

        $loom = new Loom(new \Loom\Years(1));
        $this->assertEquals(12, $loom->getMonths());
        $this->assertEquals(365, $loom->getDays());
    }

    /** @test */
    public function it_can_diff_another_object()
    {
        $loom = new Loom(new \Loom\Minutes(25));
        $diff = $loom->diff(new Loom(new \Loom\Minutes(20)));

        $this->assertEquals(5, $diff->getMinutes());
    }

    /** @test */
    public function it_provides_comparison_methods()
    {
        $loom_one = new Loom(new \Loom\Seconds(4000));
        $loom_two = new Loom(new \Loom\Hours(10));
        $loom_three = new Loom(new \Loom\Minutes(600));

        $this->assertFalse($loom_one->eq($loom_two));
        $this->assertTrue($loom_two->eq($loom_three));
        $this->assertTrue($loom_one->ne($loom_three));
        $this->assertTrue($loom_one->lt($loom_two));
        $this->assertTrue($loom_three->gt($loom_one));
        $this->assertTrue($loom_two->gte($loom_three));
        $this->assertTrue($loom_three->lte($loom_two));
    }
}