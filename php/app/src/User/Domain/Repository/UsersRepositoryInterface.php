<?php
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\ValueObject\UserId;

interface UsersRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function get(UserId $id): User;
    public function add(User $user): void;
    public function remove(User $user): void;

}