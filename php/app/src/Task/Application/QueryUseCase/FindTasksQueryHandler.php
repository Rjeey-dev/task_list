<?php
declare(strict_types=1);

namespace App\Task\Application\QueryUseCase;

use App\Task\Application\Query\FindTasksQuery;
use App\Task\Domain\DataProvider\TaskDataProviderInterface;
use App\Task\Domain\DTO\TasksList;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindTasksQueryHandler implements QueryUseCaseInterface
{
    private $userDataProvider;

    public function __construct(TaskDataProviderInterface $usersDataProvider)
    {
        $this->userDataProvider = $usersDataProvider;
    }

    public function __invoke(FindTasksQuery $query): TasksList
    {
        return $this->userDataProvider->findUsers($query->getOffset(), $query->getLimit(), $query->getOrder());
    }
}