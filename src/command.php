<?php

require __DIR__ . '/../vendor/autoload.php';

use Amp\Loop;
use Amp\Parallel\Worker\CallableTask;
use Amp\Parallel\Worker\DefaultPool;
use App\DataService;

// A variable to store our fetched results
$results = [];

// Mock data service, you may call db collection here
$dataService = new DataService;
$pageSize = 4;
$totalPages = ceil($dataService->getSize() / $pageSize);

// Create tasks to run them parallel
$tasks = [];
for ($page = 1; $page <= $totalPages; ++$page) {
    // [$dataService, 'get'] is a callable, it is same as $dataService->get(...)
    // The second parameter is an array, which will be use as callable's parameters
    // => $dataService->get($page, $pageSize)
    $tasks[] = new CallableTask([$dataService, 'get'], [$page, $pageSize]);
}

// Event loop for parallel tasks
Loop::run(function () use (&$results, $tasks) {
    // START: this is example to print progess bar, you may not need it
    $timer = Loop::repeat(1000, function () {
        printf(".");
    });
    Loop::unreference($timer);
    // END

    $pool = new DefaultPool;

    $coroutines = [];

    foreach ($tasks as $index => $task) {
        $coroutines[] = Amp\call(function () use ($pool, $index, $task) {
            // Result from each task
            // Task with smaller sleep_seconds will return result first
            $result = yield $pool->enqueue($task);
            printf("\nResult from task %d: %s\n", $index, json_encode($result));
            return $result;
        });
    }

    $results = yield Amp\Promise\all($coroutines);

    return yield $pool->shutdown();
});

// Results is array of items from page 1 to last page
echo "\nAll results:\n";
print_r($results);
