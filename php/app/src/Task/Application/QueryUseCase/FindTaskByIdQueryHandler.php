<?php
declare(strict_types=1);

namespace App\Task\Application\QueryUseCase;

use App\Task\Application\Query\FindTaskByIdQuery;
use App\Task\Domain\DataProvider\TaskDataProviderInterface;
use App\Task\Domain\DTO\Task;
use App\Task\Domain\Exception\TaskNotFoundException;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindTaskByIdQueryHandler implements QueryUseCaseInterface
{
    private $usersDataProvider;

    public function __construct(TaskDataProviderInterface $usersDataProvider)
    {
        $this->usersDataProvider = $usersDataProvider;
    }

    public function __invoke(FindTaskByIdQuery $query): ?Task
    {
        try {
            return $this->usersDataProvider->findUser($query->getId());
        } catch (TaskNotFoundException $e) {
            return null;
        }
    }
}