<?php
declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\Exception\ValidationException;
use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateTaskCommand implements CommandInterface
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

    public function __construct(string $name, int $status)
    {
        $this->id = TaskId::generate();
        $this->name= $name;
        $this->status = $status;
        $this->validateStatus($status);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }

    private function validateStatus(int $status): void
    {
        if (!in_array($status, self::SUPPORTED_STATUSES, true)) {
            throw new ValidationException('Status not valid');
        }
    }
}