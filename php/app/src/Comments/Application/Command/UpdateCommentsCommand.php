<?php
declare(strict_types=1);

namespace App\Comments\Application\Command;

use App\Comments\Domain\ValueObject\CommentId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateCommentsCommand implements CommandInterface
{
    private $id;
    private $userName;
    private $text;

    public function __construct(string $id, string $userName, string $text)
    {
        $this->id = new CommentId($id);
        $this->text = $text;
        $this->userName = $userName;
    }

    public function getId(): CommentId
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
