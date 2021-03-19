<?php
declare(strict_types=1);

namespace App\Task\Application\Command;

use App\Task\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateTaskCommand implements CommandInterface
{
    private $id;
    private $userName;
    private $text;

    public function __construct(string $userName, string $text)
    {
        $this->id = TaskId::generate();
        $this->userName = $userName;
        $this->text = $text;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}