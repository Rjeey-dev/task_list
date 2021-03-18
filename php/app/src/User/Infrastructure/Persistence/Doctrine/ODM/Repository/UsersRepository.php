<?php
declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Doctrine\ODM\Repository;

use App\Kernel\Doctrine\DocumentRepository;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\Repository\UsersRepositoryInterface;
use App\User\Domain\ValueObject\UserId;

class UsersRepository extends DocumentRepository implements UsersRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function add(User $user): void
    {
        $this->getDocumentManager()->persist($user);
    }

    /**
     * {@inheritDoc}
     */
    public function get(UserId $id): User
    {
        $user = $this->getDocumentManager()->find(User::class, $id->getId());

        if (!$user) {
            throw new UserNotFoundException(sprintf('User with id - %s is not found', $id->getId()));
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(User $user): void
    {
        $this->getDocumentManager()->remove($user);
    }
}