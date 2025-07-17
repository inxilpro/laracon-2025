<?php

namespace App\Console\Commands;

use App\Data\Coordinates;
use App\Models\Laracon;
use App\Models\Speaker;
use Glhd\ConveyorBelt\IteratesEnumerable;
use Illuminate\Console\Command;
use Illuminate\Support\Enumerable;
use Illuminate\Support\LazyCollection;
use stdClass;
use Symfony\Component\Yaml\Yaml;

class ImportLaraconDbCommand extends Command
{
	use IteratesEnumerable;
	
	protected const array HANDLES = [
		'Taylor Otwell' => ['x' => '@taylorotwell', 'bluesky' => 'taylorotwell.bsky.social'],
		'Freek Van der Herten' => ['x' => '@freekmurze'],
		'Marcel Pociot' => ['x' => '@marcelpociot'],
		'Nuno Maduro' => ['x' => '@enunomaduro'],
		'Christoph Rumpel' => ['x' => '@christophrumpel'],
		'Mohamed Said' => ['x' => '@themsaid'],
		'Miguel Piedrafita' => ['x' => '@m1guelpf'],
		'Caleb Porzio' => ['x' => '@calebporzio'],
		'Jeffrey Way' => ['x' => '@jeffrey_way'],
		'Adam Wathan' => ['x' => '@adamwathan'],
		'James Brooks' => ['x' => '@jbrooksuk'],
		'Luke Downing' => ['x' => '@LukeDowning19'],
		'Zuzana Kunckova' => ['x' => '@zuzana_kunckova'],
		'Aaron Francis' => ['x' => '@aarondfrancis'],
		'Steve McDougall' => ['x' => '@JustSteveKing'],
		'Ryuta Hamasaki' => ['x' => '@avosalmon'],
		'Stephen Rees-Carter' => ['x' => '@valorin'],
		'Rory McDaniel' => ['x' => '@rorycmcdaniel'],
		'Polly Washburn' => ['x' => '@codyssia'],
		'Ashley Hindle' => ['x' => '@ashleyhindle'],
		'Craig Morris' => ['x' => '@morrislaptop'],
		'Jess Archer' => ['x' => '@jessarchercodes'],
		'Shruti Balasa' => ['x' => '@shrutibalasa'],
		'Erika Heidi' => ['x' => '@erikaheidi'],
		'Diana Scharf' => ['x' => '@dianawebdev'],
		'Ryan Chandler' => ['x' => '@ryangjchandler'],
		'David Hill' => ['x' => '@iamdavidhill'],
		'John Drexler' => ['x' => '@johnrudolphdrex'],
		'Michi Hoffmann' => ['x' => '@cleptric'],
		'Chris Morrell' => ['x' => '@inxilpro', 'bluesky' => 'cmorrell.com'],
		'Simon Hamp' => ['x' => '@simonhamp'],
		'Kevin Dunglas' => ['x' => '@dunglas'],
		'Kapehe Sevilleja' => ['x' => '@kapehe_ok'],
		'Bert de Swaef' => ['x' => '@burtds'],
		'Lucas Giovanny' => ['x' => '@lucgiovanny'],
		'Khushboo Verma' => ['x' => '@khushbooverma_'],
		'Nina Karisik' => ['x' => '@nina_ajnira'],
		'Mathias Grimm' => ['x' => '@matgrimm'],
		'Vishal Rajpurohit' => ['x' => '@vishal_viitor'],
		'Mitul Golakiya' => ['x' => '@mitulgolakiya'],
		'Ruchit Patel' => ['x' => '@ruchit288'],
		'Abbas Ali' => ['x' => '@_abbas'],
		'Michele Hansen' => ['bluesky' => 'mjwhansen.com'],
		'Mathias Hansen' => ['bluesky' => 'codemonkey.io'],
		'Matt Stauffer' => ['bluesky' => 'mattstauffer.com'],
		'Jason McCreary' => ['x' => '@gonedark'],
		'Evan You' => ['bluesky' => 'evanyou.me'],
		'Caneco' => ['x' => '@caneco'],
		'Jack McDade' => ['x' => '@jackmcdade'],
		'Colin DeCarlo' => ['x' => '@colindecarlo'],
		'Dries Vints' => ['x' => '@driesvints'],
		'Rissa Jackson' => ['x' => '@rissa_bubbles'],
		'Daniel Coulbourne' => ['bluesky' => 'coulb.com'],
		'Joe Dixon' => ['x' => '@_joedixon'],
		'Joe Tannenbaum' => ['x' => '@joetannenbaum'],
		'Dayle Rees' => ['x' => '@daylerees'],
		'Shawn McCool' => ['x' => '@ShawnMcCool'],
		'Chris Fidao' => ['x' => '@fideloper'],
		'Jeremy Mikola' => ['x' => '@jmikola'],
		'Laura Elizabeth' => ['x' => '@lauraelizdunn'],
		'Wes Bos' => ['x' => '@wesbos'],
		'Jonathan Reinink' => ['x' => '@reinink'],
		'Steve Schoger' => ['x' => '@steveschoger'],
		'Tim MacDonald' => ['x' => '@timacdonald87'],
		'Ben Corlett' => ['x' => '@ben_corlett'],
		'Frank de Jonge' => ['x' => '@frankdejonge'],
		'Kévin Dunglas' => ['x' => '@dunglas'],
		'Eric Barnes' => ['x' => '@ericlbarnes'],
		'Ian Landsman' => ['bluesky' => 'ianlandsman.com'],
		'Justin Jackson' => ['bluesky' => 'justinjackson.ca'],
		'TJ Miller' => ['bluesky' => 'tjmiller.bsky.social'],
		'Tom Schlick' => ['x' => '@tomschlick'],
		'Josh Hanley' => ['bluesky' => 'joshhanley.au'],
		'Marty Friedel' => ['bluesky' => 'marty.friedel.au'],
		'Katerina Trajchevska' => ['x' => '@ktrajchevska'],
		'Franz Liedke' => ['x' => '@franzliedke'],
		'Christopher Pitt' => ['x' => '@assertchris'],
		'Sebastian De Deyne' => ['x' => '@sebdedeyne'],
		'Jeremy Lindblom' => ['x' => '@jeremeamia'],
		'Kayla Daniels' => ['x' => '@kayladnls'],
		'Eryn O\'Neil' => ['x' => '@eryno'],
		'Fabien Potencier' => ['x' => '@fabpot'],
		'Amanda Folson' => ['x' => '@AmbassadorAwsum'],
		'Matthew Machuga' => ['x' => '@machuga', 'bluesky' => 'mattmachuga.com'],
		'Sandi Metz' => ['x' => '@sandimetz'],
		'Keith Damiani' => ['x' => '@keithdamiani'],
		'Philo Hermans' => ['x' => '@philo01', 'bluesky' => 'philo01.bsky.social'],
		'Mateus Guimaraes' => ['x' => '@mateusjatenee'],
		'Konstantin Kudryashov' => ['x' => '@everzet'],
		'Mattias Geniar' => ['x' => '@mattiasgeniar'],
		'Povilas Korop' => ['x' => '@povilaskorop'],
		'Tobias Petry' => ['x' => '@tobias_petry'],
		'Dan Johnson' => ['x' => '@danjohnsonxyz'],
		'Rob Allen' => ['x' => '@akrabat'],
		'Lorna Mitchell' => ['x' => '@lornajane'],
		'Zack Kitzmiller' => ['x' => '@zackkitzmiller'],
		'Phil Sturgeon' => ['x' => '@philsturgeon'],
		'John Resig' => ['x' => '@jeresig'],
		'Ed Finkler' => ['x' => '@funkatron'],
		'Brian Webb' => ['x' => '@brianwebb01'],
		'Samantha Quiñones' => ['x' => '@facsamile'],
		'Yitzchok Willroth' => ['x' => '@coderabbi'],
		'Zeev Suraski' => ['x' => '@zeevs'],
		'Ryan Singer' => ['x' => '@rjs'],
		'Sean Larkinn' => ['x' => '@TheLarkInn'],
		'Jason Fried' => ['x' => '@jasonfried'],
		'Ryan Holiday' => ['x' => '@ryanholiday'],
		'Bobby Bouwmann' => ['x' => '@bobbybouwmann', 'bluesky' => 'bobbybouwmann.bsky.social'],
		'Primeagen' => ['x' => '@primeagen'],
		'Phill Sparks' => ['x' => '@phillsparks'],
		'Peter Suhm' => ['bluesky' => 'petersuhm.com'],
		'Isak Berglind' => ['x' => '@Isak_Berglind'],
		'Benedicte Raae' => ['x' => '@raae'],
		'Jens Just Iversen' => ['x' => '@JensJustIversen'],
		'Snipe' => ['bluesky' => 'snipe.lol'],
	];
	
	protected $signature = 'import:laracon-db {filename}';
	
	protected array $speakers = [];
	
	public function beforeFirstRow()
	{
		Laracon::truncate();
		Speaker::truncate();
	}
	
	public function collect(): Enumerable
	{
		return new LazyCollection(function() {
			$editions = Yaml::parseFile($this->argument('filename'));
			
			foreach ($editions as $name => $edition) {
				if (! str_contains($name, 'Laracon')) {
					continue;
				}
				
				foreach ($edition['events'] as $key => $event) {
					if (! isset($event['coordinates'], $event['talks'])) {
						continue;
					}
					
					$event['edition'] = $name;
					$event['year'] = $key;
					yield $key => (object) $event;
				}
			}
		});
	}
	
	public function handleRow(stdClass $item)
	{
		$speakers = collect($item->talks)
			->values()
			->pluck('speakers')
			->flatten()
			->unique()
			->sort()
			->map(function($name) {
				$handles = self::HANDLES[$name] ?? [];
				
				return $this->speakers[$name] ??= Speaker::create([
					'name' => $name,
					'twitter' => $handles['x'] ?? null,
					'bsky' => $handles['bluesky'] ?? null,
				]);
			});
		
		Laracon::create([
			'organization' => $item->edition,
			'title' => "{$item->location} ({$item->year})",
			'coordinates' => new Coordinates($item->coordinates['lat'], $item->coordinates['lng']),
			'speaker_ids' => $speakers->pluck('id')->implode(','),
		]);
	}
}
