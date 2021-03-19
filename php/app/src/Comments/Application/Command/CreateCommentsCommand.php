<?php
declare(strict_types=1);

namespace App\Comments\Application\Command;

use App\Comments\Domain\ValueObject\CommentId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateCommentsCommand implements CommandInterface
{
    private $id;
    private $userName;
    private $text;

    public function __construct(string $userName, string $text)
    {
        $this->id = CommentId::generate();
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

    public function getId(): CommentId
    {
        return $this->id;
    }
}