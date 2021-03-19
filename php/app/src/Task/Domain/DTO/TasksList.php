<?php
declare(strict_types=1);

namespace App\Task\Domain\DTO;

class TasksList
{
    private $users;
    private $totalCount;

    /**
     * @param Task[] $routes
     */
    public function __construct(array $users, int $totalCount)
    {
        $this->users = $users;
        $this->totalCount = $totalCount;
    }

    /**
     * @return Task[]
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