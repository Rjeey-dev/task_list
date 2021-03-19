<?php
declare(strict_types=1);

namespace App\Comments\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class CommentHasBeenUpdateEvent implements EventInterface
{
    private $id;
    private $userName;
    private $text;

    public function __construct(string $id, string $userName, string $text)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->text = $text;
    }

    public function getId(): string
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