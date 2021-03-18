<?php
declare(strict_types=1);

namespace App\User\Domain\DataProvider;

use App\User\Domain\DTO\User;
use App\User\Domain\DTO\UsersList;
use App\User\Domain\Exception\UserNotFoundException;
use App\User\Domain\ValueObject\UserId;

interface UsersDataProviderInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function findUser(UserId $id): User;
    public function findUsers(int $offset, int $limit, string $order): UsersList;
}