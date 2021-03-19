<?php
declare(strict_types=1);

namespace App\Task\Application\Command;

use App\Task\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateTaskCommand implements CommandInterface
{
    private $id;
    private $userName;
    private $text;

    public function __construct(string $id, string $userName, string $text)
    {
        $this->id = new TaskId($id);
        $this->text = $text;
        $this->userName = $userName;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
