<?php
declare(strict_types=1);

namespace App\Task\Domain\Repository;

use App\Task\Domain\Entity\Task;
use App\Task\Domain\Exception\TaskNotFoundException;
use App\Task\Domain\ValueObject\TaskId;

interface TasksRepositoryInterface
{
    /**
     * @throws TaskNotFoundException
     */
    public function get(TaskId $id): Task;
    public function add(Task $user): void;
    public function remove(Task $user): void;

}