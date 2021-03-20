<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class TaskHasBeenUpdateEvent implements EventInterface
{
    private $id;
    private $todo;
    private $doing;
    private $done;

    public function __construct(string $id, string $todo, string $doing, string $done)
    {
        $this->id = $id;
        $this->todo = $todo;
        $this->doing = $doing;
        $this->done = $done;
    }

    public function getId(): string
    {
        return $this->id;
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
}