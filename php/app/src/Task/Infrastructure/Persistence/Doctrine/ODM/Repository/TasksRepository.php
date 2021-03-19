<?php
declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\ODM\Repository;

use App\Kernel\Doctrine\DocumentRepository;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Exception\TaskNotFoundException;
use App\Task\Domain\Repository\TasksRepositoryInterface;
use App\Task\Domain\ValueObject\TaskId;

class TasksRepository extends DocumentRepository implements TasksRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function add(Task$user): void
    {
        $this->getDocumentManager()->persist($user);
    }

    /**
     * {@inheritDoc}
     */
    public function get(TaskId $id): Task
    {
        $user = $this->getDocumentManager()->find(Task::class, $id->getId());

        if (!$user) {
            throw new TaskNotFoundException(sprintf('Task with id - %s is not found', $id->getId()));
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(Task$user): void
    {
        $this->getDocumentManager()->remove($user);
    }
}