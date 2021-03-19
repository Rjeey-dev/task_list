<?php
declare(strict_types=1);

namespace App\Task\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\Task\Domain\DataProvider\TaskDataProviderInterface;
use App\Task\Domain\DTO\Task;
use App\Task\Domain\DTO\TasksList;
use App\Task\Domain\Entity\Task as  TaskEntity;
use App\Task\Domain\Exception\TaskNotFoundException;
use App\Task\Domain\ValueObject\TaskId;

class TaskDataProvider extends DocumentRepository implements TaskDataProviderInterface
{
    public function findUser(TaskId $id): Task
    {
        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class)
            ->field('id')->equals($id->getId())
            ->hydrate(false)
            ->getQuery();

        if (!$user = $query->getSingleResult()) {
            throw new TaskNotFoundException(sprintf('Task %s not found', $id->getId()));
        }

        return $this->createUser($user);
    }

    public function findUsers(int $offset, int $limit, string $order): TasksList
    {
        $usersResult =[];

        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class);
        $query->skip($offset);
        $query->limit($limit);
        $query->sort('created', $order);

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $user){
            $usersResult[] = $this->createUser($user);
        }

        return new TasksList($usersResult, count($usersResult));
    }

    private function createUser(array $user): Task
    {
        return new Task(
            $user['_id'],
            $user['user_name'],
            $user['text'],
            \DateTimeImmutable::createFromMutable($user['created']->toDateTime()),
        );
    }
}