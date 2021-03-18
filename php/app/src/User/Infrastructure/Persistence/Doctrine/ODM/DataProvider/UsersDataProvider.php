<?php
declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\User\Domain\DataProvider\UsersDataProviderInterface;
use App\User\Domain\DTO\User;
use App\User\Domain\DTO\UsersList;
use App\User\Domain\Entity\User as UserEntity;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\ValueObject\UserId;

class UsersDataProvider extends DocumentRepository implements UsersDataProviderInterface
{
    public function findUser(UserId $id): User
    {
        $query = $this->getDocumentManager()->createQueryBuilder(UserEntity::class)
            ->field('id')->equals($id->getId())
            ->hydrate(false)
            ->getQuery();

        if (!$user = $query->getSingleResult()) {
            throw new UserNotFoundException(sprintf('User %s not found', $id->getId()));
        }

        return $this->createUser($user);
    }

    public function findUsers(int $offset, int $limit, string $order): UsersList
    {
        $usersResult =[];

        $query = $this->getDocumentManager()->createQueryBuilder(UserEntity::class);
        $query->skip($offset);
        $query->limit($limit);
        $query->sort('created', $order);

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $user){
            $usersResult[] = $this->createUser($user);
        }

        return new UsersList($usersResult, count($usersResult));
    }

    private function createUser(array $user): User
    {
        return new User(
            $user['_id'],
            $user['user_name'],
            $user['text'],
            \DateTimeImmutable::createFromMutable($user['created']->toDateTime()),
        );
    }
}