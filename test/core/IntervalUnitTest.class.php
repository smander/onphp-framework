<?php
	/* $Id$ */
	
	final class IntervalUnitTest extends TestCase
	{
		public function testMicrosecond()
		{
			$unit = IntervalUnit::create('microsecond');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-16 20:38:40',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testMillisecond()
		{
			$unit = IntervalUnit::create('millisecond');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-16 20:38:40',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testSecond()
		{
			$unit = IntervalUnit::create('second');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-16 20:38:40',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testMinute()
		{
			$unit = IntervalUnit::create('minute');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-16 20:38:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testHour()
		{
			$unit = IntervalUnit::create('hour');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-16 20:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testHourFloor()
		{
			$unit = IntervalUnit::create('hour');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40'),
				true
			);
			
			$this->assertEquals(
				'2001-02-16 21:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result, true)->toString()
			);
		}
		
		public function testDay()
		{
			$unit = IntervalUnit::create('day');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-16 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testWeek()
		{
			$unit = IntervalUnit::create('week');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-12 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testWeekFloor()
		{
			$unit = IntervalUnit::create('week');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40'),
				true
			);
			
			$this->assertEquals(
				'2001-02-19 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result, true)->toString()
			);
		}
		public function testMonth()
		{
			$unit = IntervalUnit::create('month');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-02-01 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testMonthFloor()
		{
			$unit = IntervalUnit::create('month');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40'),
				true
			);
			
			$this->assertEquals(
				'2001-03-01 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result, true)->toString()
			);
		}
		
		public function testYear()
		{
			$unit = IntervalUnit::create('year');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2001-01-01 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
		
		public function testYearFloor()
		{
			$unit = IntervalUnit::create('year');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40'),
				true
			);
			
			$this->assertEquals(
				'2002-01-01 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result, true)->toString()
			);
		}
		
		public function testDecade()
		{
			$unit = IntervalUnit::create('decade');
			
			$result = $unit->truncate(
				Timestamp::create('2001-02-16 20:38:40')
			);
			
			$this->assertEquals(
				'2000-01-01 00:00:00',
				$result->toString()
			);
			
			$this->assertEquals(
				$result->toString(),
				$unit->truncate($result)->toString()
			);
		}
	}
?>