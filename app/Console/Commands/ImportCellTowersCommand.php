<?php

namespace App\Console\Commands;

use App\Data\Coordinates;
use App\Models\CellTower;
use Glhd\ConveyorBelt\IteratesSpreadsheet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use stdClass;
use Throwable;

class ImportCellTowersCommand extends Command
{
	use IteratesSpreadsheet {
		mapCells as conveyorBeltMapCells;
	}
	
	protected $signature = 'import:cell-towers {filename}';
	
	public function shouldUseHeadings(): bool
	{
		return false;
	}
	
	public function mapCells(array $cells)
	{
		return $this->conveyorBeltMapCells($cells, [
			'radio',
			'mcc',
			'net',
			'area',
			'cell',
			'unit',
			'longitude',
			'latitude',
			'range',
			'samples',
			'changeable',
			'created',
			'updated',
			'averageSignal',
		]);
	}
	
	public function handleRow(stdClass $item)
	{
		try {
			CellTower::create([
				'radio' => $item->radio,
				'range' => (int) $item->range,
				'coordinates' => new Coordinates((float) $item->latitude, (float) $item->longitude),
				'created_at' => Date::createFromTimestamp($item->created, 'UTC'),
				'updated_at' => Date::createFromTimestamp($item->updated, 'UTC'),
			]);
		} catch (Throwable) {
			return;
		}
	}
}
