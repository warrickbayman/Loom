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

class LoomTest extends TestCase
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

        $loom = new Loom(new \Loom\Days(2));
        $this->assertEquals(48, $loom->getHours());
    }


    public function getFactory()
    {
        return [[new \Loom\LoomFactory()]];
    }


    /** @test
     * @dataProvider getFactory
     *
     * @param \Loom\LoomFactory $loomFactory
     */
    public function it_can_be_instantiated_using_the_factory(\Loom\LoomFactory $loomFactory)
    {
        $loom = $loomFactory->fromMilliseconds(5000);
        $this->assertEquals(5, $loom->getSeconds());
        $loom = $loomFactory->fromSeconds(240);
        $this->assertEquals(240000, $loom->getMilliseconds());
        $loom = $loomFactory->fromMinutes(8);
        $this->assertEquals(480, $loom->getSeconds());
        $loom = $loomFactory->fromHours(12);
        $this->assertEquals(0.5, $loom->getDays());
        $loom = $loomFactory->fromDays(7);
        $this->assertEquals(1, $loom->getWeeks());
        $loom = $loomFactory->fromWeeks(4);
        $this->assertEquals(28, $loom->getDays());
        $loom = $loomFactory->fromMonths(12);
        $this->assertEquals(1, $loom->getYears());
        $loom = $loomFactory->fromYears(2);
        $this->assertEquals(24, $loom->getMonths());
    }

    /** @test */
    public function it_can_be_instantiated_using_the_static_loom_method()
    {
        $loom = Loom::make()->fromSeconds(120);
        $this->assertInstanceOf('Loom\Loom', $loom);
        $this->assertEquals(2, $loom->getMinutes());
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


    /** @test */
    public function it_can_check_if_it_is_between_two_units()
    {
        $loom = Loom::make()->fromMinutes(1);
        $this->assertTrue($loom->isBetween(
            Loom::make()->fromSeconds(59),
            Loom::make()->fromMinutes(2)
        ));

        $this->assertTrue($loom->isBetween(
            Loom::make()->fromSeconds(60),
            Loom::make()->fromSeconds(61), true)
        );
    }


    /** @test */
    public function it_can_work_with_a_solar_year()
    {
        $loom = Loom::make()->fromYears(1, true);
        $this->assertEquals(\Loom\Years::SOLAR_DAYS, $loom->getDays());

        $loom = Loom::make()->fromMonths(12);
    }


    /** @test */
    public function it_can_perform_simple_arithmetic()
    {
        $loom = Loom::make()->fromMinutes(2);
        $loom->add(Loom::make()->fromSeconds(10));

        $this->assertEquals(130, $loom->getSeconds());

        $loom->sub(Loom::make()->fromHours(1));
        $this->assertEquals(0, $loom->getMinutes());
    }


    /** @test */
    public function it_can_do_arithmetic_with_units()
    {
        $loom = new \Loom\Loom(new \Loom\Days(1000));
        $result = $loom->add(new \Loom\Hours(24));

        $this->assertEquals(1001, $result->getDays());

        $result = $loom->sub(new \Loom\Hours(48));

        $this->assertEquals(999, $result->getDays());
    }


    /** @test */
    public function it_can_be_created_from_a_datetime()
    {
        date_default_timezone_set('UTC');
        $loom = Loom::make()->fromDateTime(new DateTime('2015-01-21'));
        $result = $loom->diff(Loom::make()->fromDateTime(new DateTime('2015-01-27')));

        $this->assertEquals(6, $result->getDays());

        $loom = Loom::make()->fromDateTime(new DateTime('now'));
        $result = $loom->diff(Loom::make()->fromDateTime(new DateTime('now + 22 hours')));

        $this->assertEquals(22, $result->getHours());
    }


    /** @test */
    public function it_can_get_time_since()
    {
        $loom = Loom::make()->fromTime(new DateTime('now - 5 days'));
        $result = $loom->since();

        $this->assertEquals(120, $result->getHours());
    }


    /** @test */
    public function it_can_get_time_until()
    {
        $loom = Loom::make()->fromTime(new DateTime('now + 5 days'));
        $result = $loom->until();

        $this->assertEquals(120, $result->getHours());
    }


    /** @test */
    public function it_can_work_with_microseconds()
    {
        $loom = Loom::make()->fromMicroseconds(1000000);
        $this->assertEquals(1, $loom->getSeconds());

        $loom->add(Loom::make()->fromSeconds(1));
        $this->assertEquals(2000000, $loom->getMicroseconds());
    }
}