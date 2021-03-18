<?php
declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    private $id;
    private $userName;
    private $text;

    public function __construct(string $userName, string $text)
    {
        $this->id = UserId::generate();
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

    public function getId(): UserId
    {
        return $this->id;
    }
}