<?php

namespace App;

class DataService
{
	private $items = [
		'Item 1',
		'Item 2',
		'Item 3',
		'Item 4',
		'Item 5',
		'Item 6',
		'Item 7',
		'Item 8',
		'Item 9',
		'Item 10',
		'Item 11',
		'Item 12',
		'Item 13',
		'Item 14',
	];

	public function getSize()
	{
		return count($this->items);
	}

	public function get($page, $pageSize)
	{
		$sleepSeconds = random_int(1, 10); // Mocking slow task, e.g. get from db
        sleep($sleepSeconds);

        return [
            'sleep_seconds' => $sleepSeconds,
            'page' => $page,
            'page_size' => $pageSize,
            'data' => array_slice($this->items, ($page - 1) * $pageSize, $pageSize),
        ];
	}
}
