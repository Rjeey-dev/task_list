<?php
declare(strict_types=1);

namespace App\Task\Domain\DataProvider;

use App\Task\Domain\DTO\Task;
use App\Task\Domain\DTO\TasksList;
use App\Task\Domain\Exception\TaskNotFoundException;
use App\Task\Domain\ValueObject\TaskId;

interface TaskDataProviderInterface
{
    /**
     * @throws TaskNotFoundException
     */
    public function findUser(TaskId $id): Task;
    public function findUsers(int $offset, int $limit, string $order): TasksList;
}