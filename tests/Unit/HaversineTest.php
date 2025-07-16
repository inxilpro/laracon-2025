<?php

namespace Tests\Unit;

use App\Data\Coordinate;
use App\Support\Haversine;
use PHPUnit\Framework\TestCase;

class HaversineTest extends TestCase
{
    public function test_calculates_distance_between_new_york_and_los_angeles(): void
    {
        $ny = new Coordinate(40.7128, -74.0060);
        $la = new Coordinate(34.0522, -118.2437);
        
        $haversine = new Haversine($ny, $la);
        
        $this->assertEqualsWithDelta(2445.56, $haversine->miles(), 0.5);
        $this->assertEqualsWithDelta(3935.75, $haversine->km(), 0.5);
    }
    
    public function test_calculates_distance_between_london_and_paris(): void
    {
        $london = new Coordinate(51.5074, -0.1278);
        $paris = new Coordinate(48.8566, 2.3522);
        
        $haversine = new Haversine($london, $paris);
        
        $this->assertEqualsWithDelta(213.01, $haversine->miles(), 0.5);
        $this->assertEqualsWithDelta(343.56, $haversine->km(), 0.5);
    }
    
    public function test_calculates_zero_distance_for_same_location(): void
    {
        $location = new Coordinate(37.7749, -122.4194);
        
        $haversine = new Haversine($location, $location);
        
        $this->assertEquals(0, $haversine->miles());
        $this->assertEquals(0, $haversine->km());
    }
    
    public function test_handles_antipodal_points(): void
    {
        $north_pole = new Coordinate(90, 0);
        $south_pole = new Coordinate(-90, 0);
        
        $haversine = new Haversine($north_pole, $south_pole);
        
        $this->assertEqualsWithDelta(12436.8, $haversine->miles(), 1);
        $this->assertEqualsWithDelta(20015.1, $haversine->km(), 1);
    }
    
    public function test_handles_equatorial_half_circumference(): void
    {
        $point1 = new Coordinate(0, 0);
        $point2 = new Coordinate(0, 180);
        
        $haversine = new Haversine($point1, $point2);
        
        $this->assertEqualsWithDelta(12436.8, $haversine->miles(), 1);
        $this->assertEqualsWithDelta(20015.1, $haversine->km(), 1);
    }
}
