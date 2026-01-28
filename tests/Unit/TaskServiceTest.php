<?php

namespace Tests\Unit;

use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Structures\SearchTasksData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    private const USER_ID = 1;
    private const DESCRIPTION = 'partial description';
    private const STATUS = true;
    private const PRIORITY = 1;

    private array $filters = [];
    private array $optionalFilters = [];
    private array $searchPartials = [];
    private array $optionalSearchPartials = [];
    private TaskService $taskService;

    protected function setUp(): void
    {
        parent::setUp();
        $taskRepository = $this->mockTaskRepository();
        $this->taskService = new TaskService($taskRepository);
    }

    /**
     * @dataProvider filtersProvider
     */
    public function testGetTasksWithFilters(
        SearchTasksData $data,
        array           $expectedFilters,
        array           $expectedOptionalFilters,
        array           $expectedSearchPartials,
        array           $expectedOptionalSearchPartials
    ): void
    {
        $this->taskService->getTasksWithFilters($data);

        $this->assertSame($expectedFilters, $this->filters);
        $this->assertSame($expectedOptionalFilters, $this->optionalFilters);
        $this->assertSame($expectedSearchPartials, $this->searchPartials);
        $this->assertSame($expectedOptionalSearchPartials, $this->optionalSearchPartials);
    }

    public function testOptionalMatchWithPriorityAndDescription(): void
    {
        $data = new SearchTasksData(self::USER_ID);
        $data->exactMatch = false;

        $data->priority = self::PRIORITY;
        $data->description = self::DESCRIPTION;

        $expectedFilters = ['user_id' => self::USER_ID];
        $expectedOptionalFilters = ['priority' => self::PRIORITY];
        $expectedSearchPartials = [];
        $expectedOptionalSearchPartials = ['description' => self::DESCRIPTION];

        $this->taskService->getTasksWithFilters($data);

        $this->assertSame($expectedFilters, $this->filters);
        $this->assertSame($expectedOptionalFilters, $this->optionalFilters);
        $this->assertSame($expectedSearchPartials, $this->searchPartials);
        $this->assertSame($expectedOptionalSearchPartials, $this->optionalSearchPartials);
    }

    public static function filtersProvider(): array
    {
        return [
            'only user id' => [
                self::makeSearchData(),
                ['user_id' => self::USER_ID],
                [],
                [],
                [],
            ],

            'with description' => [
                self::makeSearchData([
                    'description' => self::DESCRIPTION,
                ]),
                ['user_id' => self::USER_ID],
                [],
                ['description' => self::DESCRIPTION],
                [],
            ],

            'with priority' => [
                self::makeSearchData([
                    'priority' => self::PRIORITY,
                ]),
                ['user_id' => self::USER_ID, 'priority' => self::PRIORITY],
                [],
                [],
                [],
            ],

            'with status' => [
                self::makeSearchData([
                    'status' => self::STATUS,
                ]),
                ['user_id' => self::USER_ID, 'status' => self::STATUS],
                [],
                [],
                [],
            ],

            'with all params' => [
                self::makeSearchData([
                    'description' => self::DESCRIPTION,
                    'status' => self::STATUS,
                    'priority' => self::PRIORITY,
                ]),
                ['user_id' => self::USER_ID, 'priority' => self::PRIORITY, 'status' => self::STATUS],
                [],
                ['description' => self::DESCRIPTION],
                [],
            ],

            'optional match with all params' => [
                self::makeSearchData([
                    'exactMatch' => false,
                    'description' => self::DESCRIPTION,
                    'status' => self::STATUS,
                    'priority' => self::PRIORITY,
                ]),
                ['user_id' => self::USER_ID,],
                ['priority' => self::PRIORITY, 'status' => self::STATUS],
                [],
                ['description' => self::DESCRIPTION],
            ],

            'optional match with status and description' => [
                self::makeSearchData([
                    'exactMatch' => false,
                    'description' => self::DESCRIPTION,
                    'status' => self::STATUS,
                ]),
                ['user_id' => self::USER_ID,],
                ['status' => self::STATUS],
                [],
                ['description' => self::DESCRIPTION],
            ],
        ];
    }

    /**
     * @param array $overrides
     * @return SearchTasksData
     */
    private static function makeSearchData(array $overrides = []): SearchTasksData
    {
        $data = new SearchTasksData(self::USER_ID);

        foreach ($overrides as $property => $value) {
            $data->{$property} = $value;
        }

        return $data;
    }


    /**
     * @return TaskRepository
     */
    private function mockTaskRepository(): TaskRepository
    {
        $repository = $this->getMockBuilder(TaskRepository::class)
            ->onlyMethods(['paginateWithFilters'])
            ->getMock();

        $repository->method('paginateWithFilters')->willReturnCallback(
            function (
                array $filters = [],
                array $optionalFilters = [],
                array $searchPartials = [],
                array $optionalSearchPartials = []
            ) {
                $this->filters = $filters;
                $this->optionalFilters = $optionalFilters;
                $this->searchPartials = $searchPartials;
                $this->optionalSearchPartials = $optionalSearchPartials;

                return $this->getMockBuilder(LengthAwarePaginator::class)->getMock();
            }
        );

        return $repository;
    }
}
