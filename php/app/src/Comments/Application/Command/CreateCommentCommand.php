<?php
declare(strict_types=1);

namespace App\Comments\Application\Command;

use App\Comments\Domain\ValueObject\CommentId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateCommentCommand implements CommandInterface
{
    private $id;
    private $comment;
    private $text;

    public function __construct(string $comment, string $text)
    {
        $this->id = CommentId::generate();
        $this->comment = $comment;
        $this->text = $text;
    }

    public function getComment(): string
    {
        return $this->comment;
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