<?php
declare(strict_types=1);

namespace App\Comments\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\Comments\Domain\DataProvider\CommentDataProviderInterface;
use App\Comments\Domain\DTO\Comment;
use App\Comments\Domain\DTO\CommentsList;
use App\Comments\Domain\Entity\Comment as  TaskEntity;
use App\Comments\Domain\Exception\CommentNotFoundException;
use App\Comments\Domain\ValueObject\CommentId;

class CommentDataProvider extends DocumentRepository implements CommentDataProviderInterface
{
    public function findUser(CommentId $id): Comment
    {
        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class)
            ->field('id')->equals($id->getId())
            ->hydrate(false)
            ->getQuery();

        if (!$user = $query->getSingleResult()) {
            throw new CommentNotFoundException(sprintf('Comment %s not found', $id->getId()));
        }

        return $this->createUser($user);
    }

    public function findUsers(int $offset, int $limit, string $order): CommentsList
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

        return new CommentsList($usersResult, count($usersResult));
    }

    private function createUser(array $user): Comment
    {
        return new Comment(
            $user['_id'],
            $user['user_name'],
            $user['text'],
            \DateTimeImmutable::createFromMutable($user['created']->toDateTime()),
        );
    }
}