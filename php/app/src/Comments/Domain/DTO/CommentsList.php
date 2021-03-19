<?php
declare(strict_types=1);

namespace App\Comments\Domain\DTO;

class CommentsList
{
    private $users;
    private $totalCount;

    /**
     * @param Comment[] $routes
     */
    public function __construct(array $users, int $totalCount)
    {
        $this->users = $users;
        $this->totalCount = $totalCount;
    }

    /**
     * @return Comment[]
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