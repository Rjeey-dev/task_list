<?php
declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateTaskCommand implements CommandInterface
{
    private $id;
    private $name;
    private $status;

    public function __construct(string $id, string $name, string $status)
    {
        $this->id = new TaskId($id);
        $this->name = $name;
        $this->status = $status;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
