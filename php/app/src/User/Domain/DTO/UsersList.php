<?php
declare(strict_types=1);

namespace App\User\Domain\DTO;

class UsersList
{
    private $users;
    private $totalCount;

    /**
     * @param User[] $routes
     */
    public function __construct(array $users, int $totalCount)
    {
        $this->users = $users;
        $this->totalCount = $totalCount;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}