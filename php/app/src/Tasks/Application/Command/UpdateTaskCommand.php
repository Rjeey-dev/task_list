<?php
declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateTaskCommand implements CommandInterface
{
    private const STATUS_TODO = 0;
    private const STATUS_DOING = 1;
    private const STATUS_DONE = 2;

    private const SUPPORTED_STATUSES = [
        self::STATUS_TODO,
        self::STATUS_DOING,
        self::STATUS_DONE,
    ];

    private $id;
    private $name;
    private $status;

    public function __construct(string $id, string $name, int $status)
    {
        $this->id = new TaskId($id);
        $this->name = $name;
        $this->status = $status;
        $this->validateStatus($status);
    }

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    private function validateStatus(int $status): void
    {
        if (!in_array($status, self::SUPPORTED_STATUSES, true)) {
            throw new \App\Tasks\Domain\Exception\ValidationException('Status not valid');
        }
    }
}
