<?php
declare(strict_types=1);

namespace App\Tasks\Application\Command;

use App\Tasks\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateTaskCommand implements CommandInterface
{
    private $id;
    private $todo;
    private $doing;
    private $done;

    public function __construct(string $todo, string $doing, string $done)
    {
        $this->id = TaskId::generate();
        $this->todo = $todo;
        $this->doing = $doing;
        $this->done = $done;
    }

    public function getTodo(): string
    {
        return $this->todo;
    }

    public function getDoing(): string
    {
        return $this->doing;
    }

    public function getDone(): string
    {
        return $this->done;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}