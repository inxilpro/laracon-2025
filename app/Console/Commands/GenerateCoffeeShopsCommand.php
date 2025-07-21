<?php

namespace App\Console\Commands;

use App\Models\CoffeeShop;
use App\Models\Event;
use App\Support\Haversine;
use Glhd\ConveyorBelt\IteratesIdQuery;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Throwable;

class GenerateCoffeeShopsCommand extends Command
{
	protected const array NAMES = [
		// Major National Chains
		"Starbucks",
		"Dunkin'",
		"Peet's Coffee",
		"The Coffee Bean & Tea Leaf",
		"Caribou Coffee",
		"Tim Hortons",
		"Dutch Bros Coffee",
		"Biggby Coffee",
		"Scooter's Coffee",
		"Black Rock Coffee Bar",
		
		// Third Wave Coffee Pioneers
		"Blue Bottle Coffee",
		"Intelligentsia Coffee",
		"Counter Culture Coffee",
		"Stumptown Coffee Roasters",
		"Philz Coffee",
		
		// Regional Chains & Notable Independents
		"Joe Coffee",
		"Irving Farm Coffee Roasters",
		"Gregory's Coffee",
		"Birch Coffee",
		"Variety Coffee Roasters",
		"Coffee Project",
		"Grumpy Coffee",
		"Caffe Ladro",
		"PT's Coffee Roasting Co.",
		"Madcap Coffee",
		"Ritual Coffee Roasters",
		"Four Barrel Coffee",
		"Sightglass Coffee",
		"Verve Coffee Roasters",
		"La Colombe Coffee Roasters",
		"George Howell Coffee",
		"Gimme! Coffee",
		"Toby's Estate Coffee",
		"Bluestone Lane",
		"Think Coffee",
		"Cafe Grumpy",
		"Ninth Street Espresso",
		"Abraco",
		"Happy Bones",
		"Everyman Espresso",
		"Culture Espresso",
		"Gasoline Alley Coffee",
		"Hi-Collar",
		"Cafe Integral",
		"Partners Coffee",
		"Kobrick Coffee Co.",
		"Oren's Daily Roast",
		"McNulty's Tea & Coffee Co.",
		"Porto Rico Importing Co.",
		"Birch Coffee Co.",
		"Box Kite Coffee",
		"Café Henrie",
		"Dimes Market",
		"Ground Support Cafe",
		"Hungry Ghost",
		"Jack's Wife Freda",
		"Kaffe 1668",
		"Mud Coffee",
		"Oslo Coffee Roasters",
		"Pushcart Coffee",
		"Ralph's Coffee",
		"Sweetleaf Coffee Roasters",
		"The Roost",
		"Victrola Coffee Roasters",
		"Analog Coffee",
		"Coava Coffee Roasters",
		"Heart Coffee Roasters",
		"Never Coffee Lab",
		"Proud Mary Coffee",
		"Ruby Coffee Roasters",
		"Water Avenue Coffee",
		"Woodcat Coffee Bar",
		"Case Study Coffee",
		"Cognoscenti Coffee",
		"Go Get Em Tiger",
		"Groundwork Coffee",
		"Handsome Coffee Roasters",
		"Menotti's Coffee Stop",
		"République",
		"Republique Coffee Bar",
		"Sqirl",
		"The Conservatory for Coffee",
		"Tierra Mia Coffee",
		"Urth Caffé",
		"Caffe Luxxe",
		"Alfred Coffee",
		"Blue Star Donuts",
		"Dragonfly Coffee House",
		"Extracto Coffee Roasters",
		"Ristretto Roasters",
		"Sterling Coffee Roasters",
		"Stumptown Coffee Bar",
		"Barista",
		"Café Vita",
		"Cherry Street Coffee House",
		"Espresso Vivace",
		"Fuel Coffee",
		"Milstead & Co.",
		"Slate Coffee Roasters"
	];
	
	use IteratesIdQuery;
	
	protected $signature = 'generate:coffee-shops';
	
	public function beforeFirstRow()
	{
		CoffeeShop::truncate();
	}
	
	public function query()
	{
		return Event::query();
	}
	
	public function handleRow(Event $row)
	{
		$shops = random_int(5, 20);
		
		if (str_contains($row->title, 'Dallas')) {
			$shops = 2;
		}
		
		for ($i = 0; $i < $shops; $i++) {
			try {
				CoffeeShop::create([
					'name' => Arr::random(static::NAMES),
					'location' => Haversine::random($row->coordinates(), 200, 1000),
				]);
			} catch (Throwable) {
			}
		}
		
		for ($i = 0; $i < $shops; $i++) {
			try {
				CoffeeShop::create([
					'name' => Arr::random(static::NAMES),
					'location' => Haversine::random($row->coordinates(), 1001, 2500),
				]);
			} catch (Throwable) {
			}
		}
	}
}
